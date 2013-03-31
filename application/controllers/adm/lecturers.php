<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lecturers extends CI_Controller
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
     * retrieve a list of all lecturers
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       int         $module_id The id of module
     * @return      array       array of lecturers data for specified module
     * @since 0.1
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        
        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['all_lecturers'] = $this->users_model->get_all_lecturers();
        $data['home_link'] = base_url() . 'adm';
        $data['title'] = 'Admin Section';

        $this->load->view('header_view', $data);
        $this->load->view('adm/all_lecturers_list', $data);
        $this->load->view('footer_view');
    }


    public function remove_lecturer()
    {
        
    }

    /*
     * -------- Ajax form checks -----------
     * -------------------------------------
     */
    /**
     * used by the "Add a New Lecturer" link shown at the top of  adm/all_lecturers_list.
     * If all fields pass validation then the form data is submitted to the users model
     * to insert a new studetn into the database
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             add_lecturer_form
     * 
     * @param int           $user_id                    
     * @param string        $lecturer_first_name           
     * @param string        $lecturer_last_name           
     * @param date          $lecturer_DoB            
     * @param string        $lecturer_email            
     * @param string        $lecturer_username          
     * @param string        $lecturer_password          
     * @param int           $user_role_id       lecturers - 2, lecturers  = 3          
     */
    public function create_lecturer()
    {
        $lecturer_number = null;
        $lecturer_first_name = strip_tags($this->input->post('lecturerFirstName'));
        $lecturer_last_name = strip_tags($this->input->post('lecturerLastName'));
        $lecturer_DoB = strip_tags($this->input->post('lecturerDoB'));
        $lecturer_email = strip_tags($this->input->post('lecturerEmail'));
        $lecturer_username = strip_tags($this->input->post('lecturerUsername'));
        $lecturer_password = strip_tags($this->input->post('lecturerPassword'));
        $user_role_id = 2;

        if ($this->check_lecturer_first_name()
                && $this->check_lecturer_last_name()
                && $this->check_lecturer_date_of_birth()
                && $this->check_lecturer_email()
                && $this->check_lecturer_username()
                && $this->check_lecturer_password()
        )
        {
            //if all check are ok, then send data to the users model
            $this->users_model->user_create($lecturer_number, $lecturer_first_name, 
                    $lecturer_last_name, $lecturer_DoB, $lecturer_email, $lecturer_username, 
                    $lecturer_password, $user_role_id
            );
            print('everything is good to go');
        }
        else
        {
            echo '<br/>All fields required</br> Error: Form was not submitted.';
        }
    }
    
    /**
     * used by the "edit" button shown with each lecturer on view adm/all_lecturers_list.
     * If all fields pass validation then the form data is submitted to the users model
     * to update that specific user
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             edit_lecturer_form
     * 
     * @param int           $user_id                    
     * @param string        $lecturer_first_name           
     * @param string        $lecturer_last_name           
     * @param date          $lecturer_DoB            
     * @param string        $lecturer_email            
     * @param string        $lecturer_username          
     * @param string        $lecturer_password          
     */
    public function edit_lecturer()
    {
        $user_id = $this->input->post('userID');
        $lecturer_number = null;
        $lecturer_first_name = strip_tags($this->input->post('lecturerFirstName'));
        $lecturer_last_name = strip_tags($this->input->post('lecturerLastName'));
        $lecturer_DoB = strip_tags($this->input->post('lecturerDoB'));
        $lecturer_email = strip_tags($this->input->post('lecturerEmail'));
        $lecturer_username = strip_tags($this->input->post('lecturerUsername'));
        $lecturer_password = strip_tags($this->input->post('lecturerPassword'));

        if ($this->check_lecturer_first_name()
                && $this->check_lecturer_last_name()
                && $this->check_lecturer_date_of_birth()
                && $this->check_lecturer_email()
                && $this->check_lecturer_username()
                && $this->check_lecturer_password()
        )
        {
            //if all check are ok, then send data to the users model
            $this->users_model->user_update($user_id, $lecturer_number, $lecturer_first_name, $lecturer_last_name, $lecturer_DoB, $lecturer_email, $lecturer_username, $lecturer_password
            );

            print('everything is good to go');
        }
        else
        {
            echo '<br/>All fields required</br> Error: Form was not submitted.';
        }
    }

    /**
     * Overview:        checks if lecturer name has alphabetical characters only
     * 
     * @used by:        part of ajax forms  - create/edit lecturer
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      lecturerFirstName      description
     *
     */
    function check_lecturer_first_name()
    {
        $this->form_validation->set_rules('lecturerFirstName', 'Lecturer First Name', 'trim|required|xss_clean|alpha');

        if ($this->form_validation->run() == FALSE)
        {
            print('Name must only contain aphabetical characters.');
        }
        else
        {
            return true;
        }
    }

    function check_lecturer_last_name()
    {
        $this->form_validation->set_rules('lecturerLastName', 'Lecturer Last Name', 'trim|required|xss_clean|alpha');

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
     * used to check lecturers date of birth is valid
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             create/edit lecturer
     *  
     * @param string        $assessmentDate
     * 
     * @return boolean      True or error message
     */
    public function check_lecturer_date_of_birth()
    {
        $date_of_birth = $this->input->post('lecturerDoB');

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

                // check that lecturer is over 16 years
//                elseif(strtotime($age_check) > strtotime($todays_date))
//                {
//                    print('Lecturers must 18 years or older.');
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
     * Overview:        checks if lecturer email is valid and unique
     * 
     * @used by:        part of ajax forms  - create/edit lecturer
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      lecturerFirstName      description
     *
     */
    function check_lecturer_email()
    {
        $this->form_validation->set_rules('lecturerEmail', 'Lecturer Email', 'trim|required|xss_clean|valid_email');

        if ($this->form_validation->run() == FALSE)
        {
            print('Must be a valid email address.');
        }
        else
        {
            $lecturer_email = strip_tags($this->input->post('lecturerEmail'));
            $user_id = strip_tags($this->input->post('userID'));

            $result = $this->users_model->is_user_email_unique($user_id, $lecturer_email);
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
     * Overview:        checks if lecturer username is valid and unique
     * 
     * @used by:        part of ajax forms  - create/edit lecturer
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      lecturerUsername
     *
     */
    function check_lecturer_username()
    {
        $this->form_validation->set_rules('lecturerUsername', 'Lecturer Username', 'trim|required|xss_clean|alpha_numeric|min_length[6]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Usernames can only contain alpha numeric character and be a minimum of 6 characters.');
        }
        else
        {
            $lecturer_username = $this->input->post('lecturerUsername');
            $user_id = $this->input->post('userID');

            $result = $this->users_model->is_username_unique($user_id, $lecturer_username);
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
     * Overview:        checks if lecturer password is valid
     * 
     * @used by:        part of ajax forms  - create/edit lecturer
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           string      lecturerPassword
     *
     */
    function check_lecturer_password()
    {
        $this->form_validation->set_rules('lecturerPassword', 'Lecturer Password', 'trim|required|xss_clean|alpha_numeric|min_length[6]');

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