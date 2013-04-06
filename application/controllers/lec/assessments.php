<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assessments extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // make sure user has the correct permisson to access this controller
        if (!$this->session->userdata('user_id'))
        {
            //echo "You are not logged in";
            redirect(base_url() . 'login');
        }
        else
        {
            $config['user_id'] = $this->session->userdata['user_id'];
            $this->load->library('acl', $config);
            
            if (!$this->acl->hasPermission('access_lecturer') === TRUE)
            {
                redirect(base_url() . 'logout');
            }
            else
            {
                $this->load->model('assignments_model');
                $this->load->model('exams_model');
                $this->load->model('modules_model');
                $this->load->model('users_model');
            }
        }
    }

    /*
     * get all notes list
     */

    public function index($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'lec');
        }
        
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['module_details'] = $this->modules_model->module_details($module_id);


        $data['times'] = array(
            "07:00", "07:15", "07:30", "07:45", "08:00", "08:15", "08:30", "08:45", "09:00",
            "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30",
            "11:45", "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45", "14:00",
            "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45", "16:00", "16:15", "16:30",
            "16:45", "17:00", "17:15", "17:30", "17:45", "18:00", "18:15", "18:30", "18:45", "19:00",
            "19:15", "19:30", "19:45", "20:00", "20:15", "20:30", "20:45", "21:00", "21:15", "21:30",
            "21:45", "22:00", "22:15", "22:30", "22:45"
        );
        $data['module_assignments'] = $this->assignments_model->assignments_list($module_id);
        $data['module_exams'] = $this->exams_model->exams_list($module_id);
        $data['home_link'] = base_url() . 'lec';
        $data['title'] = 'Lecturer Section';
        $data['page_name'] = 'assessments'; // used by header navigation to show active page.

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/assessments_view', $data);
        $this->load->view('footer_view');
    }

    /*
     * @todo - add view, download and delete to notes list
     * @todo - upload_notes will option diplayed at bottom of list
     */

    public function view_notes_description()
    {
        echo 'view_notes_description' . $module_id;
    }

    // --------------- Schedule an edit an Exam ---------------------------------------
    /**
     * used by the "schedule exam" button on lec/assessmentsts.
     * If all fields pass validation then the form data is submitted to the exam model
     * to be inserted into the database
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             schedule_exam_form
     * 
     * @param int           $module_id                  The module id that this exam will be associated with
     * @param string        $assessment_title           The title for the exam
     * @param date          $assessment_date            The date for the exam
     * @param time          $exam_start_time            The exam's start time
     * @param time          $exam_end_time              The exam's finish time
     * @param int           $assessment_weighting       The Continueous Assessment Weighting for the exam
     * @param string        $assessment_description     An optional description for the exam
     */
    public function schedule_exam()
    {
        $module_id = $this->input->post('moduleID');
        $assessment_title = strip_tags($this->input->post('assessmentTitle'));
        $assessment_date = strip_tags($this->input->post('assessmentDate'));
        $exam_start_time = $this->input->post('examStartTime');
        $exam_end_time = $this->input->post('examEndTime');
        $assessment_weighting = strip_tags($this->input->post('assessmentWeighting'));
        $assessment_description = strip_tags($this->input->post('assessmentDescription'));

        if ($this->check_assessment_title($assessment_title)
                && $this->check_assessment_date($assessment_date)
                && $this->check_exam_end_time($exam_start_time, $exam_end_time)
                && $this->check_assessment_weighting($assessment_weighting)
                && $this->check_assessment_description($assessment_description))
        {
            // Don't put the default text into the database.
            if ($assessment_description === '(Optional)')
            {
                $assessment_description = '';
            }
            //if all check are ok, then send data to the model
            $this->exams_model->create_new_exam($module_id, $assessment_title, $assessment_date, $exam_start_time, $exam_end_time, $assessment_weighting, $assessment_description);
            echo 'everything is good to go';
        }
        else
        {
            echo '<br/> Error: Form was not submitted.';
        }
    }

    /**
     * used by the "edit" button shown under each exam on lec/assessmentsts.
     * If all fields pass validation then the form data is submitted to the exam model
     * to update that specific exam
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             edit_exam_form
     * 
     * @param int           $exam_id                    The id of the exam to be edited
     * @param int           $module_id                  The module id that this exam will be associated with
     * @param string        $assessment_title           The title for the exam
     * @param date          $assessment_date            The date for the exam
     * @param time          $exam_start_time            The exam's start time
     * @param time          $exam_end_time              The exam's finish time
     * @param int           $assessment_weighting       The Continueous Assessment Weighting for the exam
     * @param string        $assessment_description     An optional description for the exam
     */
    public function edit_exam()
    {
        $exam_id = $this->input->post('examID');
        $assessment_title = strip_tags($this->input->post('assessmentTitle'));
        $assessment_date = strip_tags($this->input->post('assessmentDate'));
        $exam_start_time = $this->input->post('examStartTime');
        $exam_end_time = $this->input->post('examEndTime');
        $assessment_weighting = strip_tags($this->input->post('assessmentWeighting'));
        $assessment_description = strip_tags($this->input->post('assessmentDescription'));
        $module_id = $this->input->post('moduleID');

        if ($this->check_assessment_title($assessment_title)
                && $this->check_assessment_date($assessment_date)
                && $this->check_exam_end_time($exam_start_time, $exam_end_time)
                && $this->check_assessment_weighting($assessment_weighting)
                && $this->check_assessment_description($assessment_description))
        {
            // Don't put the default text into the database.
            if ($assessment_description === '(Optional)')
            {
                $assessment_description = "";
            }

            //if all check are ok, then send data to the model
            $this->exams_model->update_exam($exam_id, $assessment_title, $assessment_date, $exam_start_time, $exam_end_time, $assessment_weighting, $assessment_description);

            echo 'everything is good to go';
        }
        else
        {
            echo '</br> Error: Form was not submitted.';
        }
    }

    // --------------- Schedule an edit an Assignment ---------------------------------------
    /**
     * used by the "Add New Assignment" button on lec/assessmentsts.
     * If all fields pass validation then the form data is submitted to the assessment model
     * to be inserted into the database
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             add_assignment_form
     * 
     * @param int           $module_id                  The module id that this exam will be associated with
     * @param string        $assessment_title           The title for the exam
     * @param date          $assessment_date            The date for the exam
     * @param int           $assessment_weighting       The Continueous Assessment Weighting for the exam
     * @param string        $assessment_description     An optional description for the exam
     */
    public function add_assignment()
    {
        $module_id = $this->input->post('moduleID');
        $assessment_title = strip_tags($this->input->post('assessmentTitle'));
        $assessment_date = strip_tags($this->input->post('assessmentDate'));
        $assessment_weighting = strip_tags($this->input->post('assessmentWeighting'));
        $assessment_description = strip_tags($this->input->post('assessmentDescription'));

        if ($this->check_assessment_title($assessment_title)
                && $this->check_assessment_date($assessment_date)
                && $this->check_assessment_weighting($assessment_weighting)
                && $this->check_assessment_description($assessment_description))
        {
            // Don't put the default text into the database.
            if ($assessment_description === '(Optional)')
            {
                $assessment_description = '';
            }


            //if all check are ok, then send data to the model
            $this->assignments_model->create_new_assignment($module_id, $assessment_title, $assessment_date, $assessment_weighting, $assessment_description);
            echo 'everything is good to go';
        }
        else
        {
            echo '</br> Error: Form was not submitted.';
        }
    }

    /**
     * used by the "edit" button shown under each assignment on lec/assessmentsts.
     * If all fields pass validation then the form data is submitted to the assignment model
     * to update this specific assignment
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             edit_assignment_form
     * 
     * @param int           $assignment_id              The id of the assignment to be edited
     * @param int           $module_id                  The module id that this assignment will be associated with
     * @param string        $assessment_title           The title for the assignment
     * @param date          $assessment_date            The date for the assignment
     * @param int           $assessment_weighting       The Continueous Assessment Weighting for the assignment
     * @param string        $assessment_description     An optional description for the assignment
     */
    public function edit_assignment()
    {
        $assignment_id = $this->input->post('assignmentID');
        $assessment_title = strip_tags($this->input->post('assessmentTitle'));
        $assessment_date = strip_tags($this->input->post('assessmentDate'));
        $assessment_weighting = strip_tags($this->input->post('assessmentWeighting'));
        $assessment_description = strip_tags($this->input->post('assessmentDescription'));
//        $module_id = $this->input->post('moduleID');

        if ($this->check_assessment_title($assessment_title)
                && $this->check_assessment_date($assessment_date)
                && $this->check_assessment_weighting($assessment_weighting)
                && $this->check_assessment_description($assessment_description))
        {
            // Don't put the default text into the database.
            if ($assessment_description === '(Optional)')
            {
                $assessment_description = '';
            }

            //if all check are ok, then send data to the model
            $this->assignments_model->update_assignment($assignment_id, $assessment_title, $assessment_date, $assessment_weighting, $assessment_description);

            echo 'everything is good to go';
        }
        else
        {
            echo '</br> Error: Form was not submitted.';
        }
    }

    /**
     * add_notes() and do_upload() are used to upload new notes that
     * will then be added to the list of notes diplayed by index()
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       file     a file of an allowable type to be uploaded
     * @since       0.1
     */
    function add_assignment_doc()
    {
        $module_id = (int) $this->uri->segment(4);
        $assignment_id = (int) $this->uri->segment(5);

//        echo $module_id .'<br/>';
//        echo $assignment_id;
        $user_id = $this->session->userdata('user_id');

        $data['page_name'] = 'assessments';

        $data['user_details'] = $this->users_model->get_user_details($user_id);

        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['assignment_details'] = $this->assignments_model->assignment_details($assignment_id);
        $data['home_link'] = base_url() . 'lec';
        $data['title'] = 'Lecturer Section';

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/upload_assignment_form', array('error' => ' ', 'module_id' => $module_id));
        $this->load->view('footer_view');
    }

    function do_upload()
    {
        $module_id = (int) $this->uri->segment(4);
        $assignment_id = (int) $this->uri->segment(5);

        $path = "uploads/module_notes/$module_id/assignments/$assignment_id";

        if (!is_dir($path)) //create the folder if it's not already exists
        {
            mkdir($path, 0777, TRUE);
        }

        $config['upload_path'] = './' . $path . '/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|odt|ods|odp|odg';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['remove_spaces'] = 'true';
        $config['overwrite'] = 'TRUE';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());

            $data['module_details'] = $this->modules_model->module_details($module_id);
            $data['assignment_details'] = $this->assignments_model->assignment_details($assignment_id);

            $data['home_link'] = base_url() . 'lec';

            $this->load->view('header_view', $data);
            $this->load->view('lec/upload_assignment_form', $error);
            $this->load->view('footer_view');
        }
        else
        {
            $upload_data = $this->upload->data();
//            echo '<pre>';
//            print_r($upload_data);
            $this->assignments_model->add_assignment_document($assignment_id, $upload_data);
            $data = array('upload_data' => $this->upload->data());

            redirect(base_url() . 'lec/assessments/index/' . $module_id);
        }
    }

    // --------------- ajax form feild checks for exams and assignments ---------------------------------------
    /**
     * used to check exam title
     * This function is part of ajax forms on lec/assessments_view  
     * 
     * @author     Patrick Ward
     * @version    0.1
     *  
     * used by:             schedule_exam_form,
     *                      edit_exam_form
     *                      add_assignment_form
     *                      edit_assignment_form
     * 
     * 
     * @param string        $assessmentTitle
     * 
     * @return boolean      True or error message
     */
    public function check_assessment_title()
    {
        $this->form_validation->set_rules('assessmentTitle', 'Assessment Title', 'trim|required|xss_clean|min_length[5]|max_length[55]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Title must be between 5 and 55 characters.');
        }
        else
        {
            return true;
        }
    }

    /**
     * used to check that exam_end_time is later than exam_start_time
     * This function is part of ajax forms on lec/assessments_view  
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             schedule_exam_form,
     *                      edit_exam_form
     * 
     * 
     * @param string        $examStartTime
     * @param string        $examEndTime
     * 
     * @return boolean      True or error message
     */
    public function check_exam_end_time()
    {
        $start_time = $this->input->post('examStartTime');
        $end_time = $this->input->post('examEndTime');

        if ($end_time <= $start_time)
        {
            print('Exam finish time must be greater than the exams start time');
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * used to check assessmentDescription lenght < 255
     * This function is part of ajax forms on lec/assessments_view  
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             schedule_exam_form,
     *                      edit_exam_form
     *                      add_assignment_form
     *                      edit_assignment_form
     *  
     * @param string        $assessmentDescription
     * 
     * @return boolean      True or error message
     */
    public function check_assessment_description()
    {
        $this->form_validation->set_rules('assessmentDescription', 'Assessment Description', 'trim|xss_clean|max_length[255]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Description must be less than 255 characters.');
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * used to check exam date is a valid date and if it in the future
     * This function is part of ajax schedule_exam_form on lec/assessments_view  
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             schedule_exam_form,
     *                      edit_exam_form
     *                      add_assignment_form
     *                      edit_assignment_form
     *  
     * @param string        $assessmentDate
     * 
     * @return boolean      True or error message
     */
    public function check_assessment_date()
    {
        $exam_date = $this->input->post('assessmentDate');

        // Use checkdate to check if the date is a valid date
        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $exam_date))
        {
            $arr = explode("-", $exam_date);     // split string into an array
            $yy = $arr[0];            // first element of the array is year
            $mm = $arr[1];            // second element is month
            $dd = $arr[2];            // third element is days

            if (!checkdate($mm, $dd, $yy))
            {
                echo 'This is not a valid date.';
            }
            else
            {
                $exam_date = str_replace('-', '/', $exam_date);
                $exam_date = date("Y-m-d", strtotime(stripslashes($exam_date)));

                $todays_date = time();
                $todays_date = date("Y-m-d");

                if ($exam_date < $todays_date)
                {
                    print('The date you have entered is in the past.');
                }
                else if ($exam_date == $todays_date)
                {
                    print('You can not schedule an assessment for today.');
                }
                else
                {
                    return TRUE;
                }
            }
        }
        else
        {
            print('The format must be YYYY-MM-DD');
        }
    }

    /**
     * used to check that the combined continuous assessment weighting of all assessments does not exceed 100
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             schedule_exam_form,
     *                      edit_exam_form
     *                      add_assignment_form
     *                      edit_assignment_form
     *  
     * @param int           $module_id
     * @param int           $exam_id
     * @param int           $assignment_id
     * @param int           $assessmentWeighting
     * 
     * @return boolean      True or error message
     */
    public function check_assessment_weighting()
    {
        $module_id = $this->input->post('moduleID');
        $exam_id = $this->input->post('examID');
        $assignment_id = $this->input->post('assignmentID');
        $assessment_weighting = $this->input->post('assessmentWeighting');

        if (preg_match('/^[0-9]{3}$/', $assessment_weighting) ||
                preg_match('/^[0-9]{2}$/', $assessment_weighting) ||
                preg_match('/^[0-9]{1}$/', $assessment_weighting))
        {

            // get existing assessments total value
            $exams_weighting = $this->exams_model->get_exams_weighting($exam_id, $module_id);
            $assignments_weighting = $this->assignments_model->get_assignments_weighting($assignment_id, $module_id);

            // get total of exams excluding current exam if one is included
            $total_exams = 0;
            foreach ($exams_weighting as $exam_weighting)
            {
                $total_exams = $total_exams + $exam_weighting->assessment_weighting;
            }

            // get total of assignments excluding current assignment if one is included
            $total_assignments = 0;
            foreach ($assignments_weighting as $assignment_weighting)
            {
                $total_assignments = $total_assignments + $assignment_weighting->assessment_weighting;
            }

            /*
             * Continuous assessment already alocated 
             * = $total_exams + $total_assignments
             */
            $total_CA_so_far = $total_exams + $total_assignments;

            if (($total_CA_so_far + $assessment_weighting) > 100)
            {
                print('You have already alocatted ' . $total_CA_so_far . '% to other assessments.');
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            print('This must be a whole number between 0 and 100');
        }
    }
}