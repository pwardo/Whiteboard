<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Students extends CI_Controller
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
            if (!$this->acl->hasPermission('access_admin') === TRUE)
            {
                redirect(base_url() . 'logout');
            }
            else
            {
                $this->load->model('users_model');
                $this->load->model('modules_model');
            }
        }
    }

    /**
     * retrieve a list of all students
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       int         $module_id The id of module
     * @return      array       array of students data for specified module
     * @since 0.1
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        
        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['all_students'] = $this->users_model->get_all_students();
        $data['home_link'] = base_url() . 'adm';
        $data['title'] = 'Admin Section';

        $this->load->view('header_view', $data);
        $this->load->view('adm/all_students_list', $data);
        $this->load->view('footer_view');
    }


    public function remove_student()
    {
        
    }

    /*
     * -------- Ajax form checks -----------
     * -------------------------------------
     */
    /**
     * used by the "Add a New Student" link shown at the top of  adm/all_students_list.
     * If all fields pass validation then the form data is submitted to the users model
     * to insert a new studetn into the database
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             add_student_form
     * 
     * @param int           $user_id                    
     * @param int           $student_number             
     * @param string        $student_first_name           
     * @param string        $student_last_name           
     * @param date          $student_DoB            
     * @param string        $student_email            
     * @param string        $student_username          
     * @param string        $student_password          
     * @param int           $user_role_id       lecturers - 2, students  = 3          
     */
    public function create_student()
    {
        $student_number = strip_tags($this->input->post('studentNumber'));
        $student_first_name = strip_tags($this->input->post('studentFirstName'));
        $student_last_name = strip_tags($this->input->post('studentLastName'));
        $student_DoB = strip_tags($this->input->post('studentDoB'));
        $student_email = strip_tags($this->input->post('studentEmail'));
        $student_username = strip_tags($this->input->post('studentUsername'));
        $student_password = strip_tags($this->input->post('studentPassword'));
        $user_role_id = 3;

        if ($this->check_student_number()
                && $this->check_student_first_name()
                && $this->check_student_last_name()
                && $this->check_student_date_of_birth()
                && $this->check_student_email()
                && $this->check_student_username()
                && $this->check_student_password()
        )
        {
            //if all check are ok, then send data to the users model
            $this->users_model->user_create($student_number, $student_first_name, 
                    $student_last_name, $student_DoB, $student_email, $student_username, 
                    $student_password, $user_role_id
            );
            print('everything is good to go');
        }
        else
        {
            echo '<br/>All fields required</br> Error: Form was not submitted.';
        }
    }
    
    /**
     * used by the "edit" button shown with each student on view adm/all_students_list.
     * If all fields pass validation then the form data is submitted to the users model
     * to update that specific user
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             edit_student_form
     * 
     * @param int           $user_id                    
     * @param int           $student_number             
     * @param string        $student_first_name           
     * @param string        $student_last_name           
     * @param date          $student_DoB            
     * @param string        $student_email            
     * @param string        $student_username          
     * @param string        $student_password          
     */
    public function edit_student()
    {
        $user_id = $this->input->post('userID');
        $student_number = strip_tags($this->input->post('studentNumber'));
        $student_first_name = strip_tags($this->input->post('studentFirstName'));
        $student_last_name = strip_tags($this->input->post('studentLastName'));
        $student_DoB = strip_tags($this->input->post('studentDoB'));
        $student_email = strip_tags($this->input->post('studentEmail'));
        $student_username = strip_tags($this->input->post('studentUsername'));
        $student_password = strip_tags($this->input->post('studentPassword'));

        if ($this->check_student_number()
                && $this->check_student_first_name()
                && $this->check_student_last_name()
                && $this->check_student_date_of_birth()
                && $this->check_student_email()
                && $this->check_student_username()
                && $this->check_student_password()
        )
        {
            //if all check are ok, then send data to the users model
            $this->users_model->user_update($user_id, $student_number, $student_first_name, $student_last_name, $student_DoB, $student_email, $student_username, $student_password
            );

            print('everything is good to go');
        }
        else
        {
            echo '<br/>All fields required</br> Error: Form was not submitted.';
        }
    }

    /**
     * Overview:        checks if student number is unique
     * 
     * @used by:        part of ajax forms  - create/edit student
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $studentNumber      the number to check
     *
     */
    function check_student_number()
    {
        $this->form_validation->set_rules('studentNumber', 'Student Number', 'trim|required|xss_clean|exact_length[6]|integer');

        if ($this->form_validation->run() == FALSE)
        {
            print('Student Number must be 6 digits long i.e. 123456.');
        }
        else
        {
            $student_number = $this->input->post('studentNumber');
            $user_id = $this->input->post('userID');

            $result = $this->users_model->is_student_number_unique($user_id, $student_number);
            if ($result)
            {
                print('This Student Number is already being used.');
            }
            else
            {
                return true;
            }
        }
    }

    /**
     * Overview:        checks if student name has alphabetical characters only
     * 
     * @used by:        part of ajax forms  - create/edit student
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      studentFirstName      description
     *
     */
    function check_student_first_name()
    {
        $this->form_validation->set_rules('studentFirstName', 'Student First Name', 'trim|required|xss_clean|alpha');

        if ($this->form_validation->run() == FALSE)
        {
            print('Name must only contain aphabetical characters.');
        }
        else
        {
            return true;
        }
    }

    function check_student_last_name()
    {
        $this->form_validation->set_rules('studentLastName', 'Student Last Name', 'trim|required|xss_clean|alpha');

        if ($this->form_validation->run() == FALSE)
        {
            print('Name must only contain aphabetical characters.');
        }
        else
        {
            return true;
        }
    }

    /**
     * used to check students date of birth is valid
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             create/edit student
     *  
     * @param string        $assessmentDate
     * 
     * @return boolean      True or error message
     */
    public function check_student_date_of_birth()
    {
        $date_of_birth = $this->input->post('studentDoB');

        // Use checkdate to check if the date is a valid date
        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date_of_birth))
        {
            $arr = explode("-", $date_of_birth);     // split string into an array
            $yy = $arr[0];            // first element of the array is year
            $mm = $arr[1];            // second element is month
            $dd = $arr[2];            // third element is days

            if (!checkdate($mm, $dd, $yy))
            {
                echo 'This is not a valid date.';
            }
            else
            {
                $date_of_birth = str_replace('-', '/', $date_of_birth);
                $date_of_birth = date("Y-m-d", strtotime(stripslashes($date_of_birth)));

                $todays_date = time();
                $todays_date = date("Y-m-d");

//                $age_check = strtotime ( '+18 year' , strtotime ( $date_of_birth ) ) ;
//                $age_check = date ( 'Y-m-j' , $age_check );

                if ($date_of_birth > $todays_date)
                {
                    print('The date you have entered is in the furture.');
                }
                else if ($date_of_birth == $todays_date)
                {
                    print('You were born today??????');
                }

                // check that student is over 16 years
//                elseif(strtotime($age_check) > strtotime($todays_date))
//                {
//                    print('Students must 18 years or older.');
//                }
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
     * Overview:        checks if student email is valid and unique
     * 
     * @used by:        part of ajax forms  - create/edit student
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      studentFirstName      description
     *
     */
    function check_student_email()
    {
        $this->form_validation->set_rules('studentEmail', 'Student Email', 'trim|required|xss_clean|valid_email');

        if ($this->form_validation->run() == FALSE)
        {
            print('Must be a valid email address.');
        }
        else
        {
            $student_email = $this->input->post('studentEmail');
            $user_id = $this->input->post('userID');

            $result = $this->users_model->is_user_email_unique($user_id, $student_email);
            if ($result)
            {
                print('This email is already being used.');
            }
            else
            {
                return true;
            }
        }
    }

    /**
     * Overview:        checks if student username is valid and unique
     * 
     * @used by:        part of ajax forms  - create/edit student
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      studentUsername
     *
     */
    function check_student_username()
    {
        $this->form_validation->set_rules('studentUsername', 'Student Username', 'trim|required|xss_clean|alpha_numeric|min_length[6]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Usernames can only contain alpha numeric character and be a minimum of 6 characters.');
        }
        else
        {
            $student_username = $this->input->post('studentUsername');
            $user_id = $this->input->post('userID');

            $result = $this->users_model->is_username_unique($user_id, $student_username);
            if ($result)
            {
                print('This Username is already taken.');
            }
            else
            {
                return true;
            }
        }
    }

    /**
     * Overview:        checks if student password is valid
     * 
     * @used by:        part of ajax forms  - create/edit student
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      studentPassword
     *
     */
    function check_student_password()
    {
        $this->form_validation->set_rules('studentPassword', 'Student Password', 'trim|required|xss_clean|alpha_numeric|min_length[6]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Passwords can only contain alpha numeric characters and be a minimum of 6 characters.');
        }
        else
        {
            return true;
        }
    }
}