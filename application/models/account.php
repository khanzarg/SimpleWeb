<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Account extends CI_Model
{
    //Start: method tambahan untuk reset code  
    // Method ini digunakan untuk mengambil data user dari tabel user berdasarkan id user
    public function getUserInfo($ID)
    {
        $reset = $this->db->get_where('user', array('id_user' => $ID), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $reset->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $ID . ')');
            return false;
        }
    }

    // Digunakan untuk mengambil data user dari tabel 'users' berdasarkan email user
    public function getUserInfoByEmail($email)
    {
        $reset = $this->db->get_where('user', array('email' => $email), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $reset->row();
            return $row;
        }
    }

    // insert token ke dalam tabel tokens untuk kebutuhan reset password
    public function insertToken($user_ID)
    {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');

        $string = array(
            'token' => $token,
            'user_ID' => $user_ID,
            'date_created' => $date
        );
        $query = $this->db->insert_string('tokens', $string);
        $this->db->query($query);
        return $token . $user_ID;
    }

    // validasi token, apakah token ada pada tabel token? Apakah token masih bisa digunakan atau sudah kadaluarsa
    public function isTokenValid($token)
    {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);

        $reset = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn,
            'tokens.user_id' => $uid
        ), 1);

        if ($this->db->affected_rows() > 0) {
            $row = $reset->row();

            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }

    // Sudah pasti digunakan untuk memperbaharui password user
    public function updatePassword($post)
    {
        $this->db->where('id_user', $post['id_user']);
        $this->db->update('user', array('password' => $post['password']));
        return true;
    }
    //End: method tambahan untuk reset code  
}
