<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    // Ini Api Untuk Panggil data ya di insert

    function getMakanan(){

       $hasil = $this->db->get("tb_menu");
      
       // cek kondisi ada datanya apa gak
       if ($hasil -> num_rows() > 0) {
        // Bikin respones k emobile
        $data["pesan"] = "datanya ada";
        $data["sukses"] = true;
        $data['data'] = $hasil->result();
       }
       else{
        $data["pesan"] = "datanya gak ada bang";
        $data["sukses"] = false;
       }

     echo json_encode($data);

    } 

    function updateMakanan(){

       // Variabel inputan mobile Kopas
       $name = $this->input->post("name");
       $price = $this->input->post("price");
       $gambar = $this->input->post("gambar");
       $id = $this->input->post("id");

       $this->db->where('menu_id',$id);
       $getId = $this->db->get('tb_menu');

       if ($getId -> num_rows() == 0) {
          $data['sukses'] = false;
          $data['pesan'] = "produk belum ada bang";
       }
       else{

          $this->db->where('menu_id',$id);

          $update['menu_nama'] = $name;
          $update['menu_harga'] = $price;
          $update['menu_gambar'] = $gambar;

          // Query Update
          $status = $this->db->update('tb_menu',$update);

          // Cek
          if ($status) {
            $data['sukses'] = true;
            $data['pesan'] = "Update berhasil";
          }
          else{
            $data['sukses'] = false;
            $data['pesan'] = "Update tidak berhasil";
         }
      } 

     echo json_encode($data);

    }

    // Untuk mengambil data menu berdasarkan id nya
    function getDetailMakanan($id){

       $this->db->where('menu_id',$id);
       $hasil = $this->db->get("tb_menu");

       // cek kondisi ada datanya apa gak
       if ($hasil -> num_rows() > 0) {
          // Bikin respones k emobile
          $data["pesan"] = "datanya ada";
          $data["sukses"] = true;
          $data['data'] = $hasil->row();
       }
       else{
          $data["pesan"] = "datanya tidak ditemukan";
          $data["sukses"] = false;
       }
     
     echo json_encode($data);
    } 

    function deleteMakanan(){

        $id = $this->input->post("id");

        $this->db->where('menu_id',$id);
        $getId = $this->db->get('tb_menu');

        if ($getId -> num_rows() == 0) {
          $data['sukses'] = false;
          $data['pesan'] = "produk belum ada bang Gak Bisa Hapus";
        }
        else{

          $this->db->where('menu_id',$id);
          $hasil = $this->db->delete('tb_menu');

          if ($hasil ) {
            // Bikin respones ke mobile
            $data["pesan"] = "Berhasil Hapus Data Bang";
            $data["sukses"] = true;
          }
          else{
            $data["pesan"] = "datanya gak bisa dihapus";
            $data["sukses"] = false;
          }
      }

      echo json_encode($data);

    } 

    function insertMakanan(){

       // Variabel inputan mobile
       $name = $this->input->post("name");
       $price = $this->input->post("price");
       $gambar = $this->input->post("gambar");

       // d implementasi nama field databasenya
       $simpan = array();
       $simpan["menu_nama"] = $name;
       $simpan["menu_harga"] = $price;
       $simpan["menu_gambar"] = $gambar;

       // Using quoery for insert database

       $status = $this->db->insert("tb_menu",$simpan);

       $data = array();
       // Cek berhasil apa gak
       if ($status) {
        $data['sukses'] = true;
        $data['pesan'] = "Insert Berhasil";
       }
       else{
        $data['sukses'] = false;
        $data['pesan'] = "Insert tidak berhasil";
       }

     echo json_encode($data);

    }

    //  ++++++++++++++++++ Buat Fungsi Register +++++++++++++++++++++

    function register(){

      //variable untuk ambil inputan dari mobile
       $name = $this->input->post("name");
       $email = $this->input->post("email");
       $password = $this->input->post("password");
       $hp = $this->input->post("hp");

       $this->db->where("user_email", $email);
       $check = $this->db->get("tb_user");

       if($check -> num_rows() > 0){

          $data["sukses"] = false ;
          $data["pesan"] = "email udah ke register,silahkan login";
       }

       else {

         //d implementasi nama field database nya
         $simpan = array();
         $simpan["user_nama"] = $name;
         $simpan["user_password"] = md5($password);
         $simpan["user_hp"] = $hp;
         $simpan["user_email"] = $email;
         
         //using query for insert database
         $status = $this->db->insert("tb_user", $simpan);

        $data = array();
        //check insertnya berhasil apa enggak
         if($status){
          $data["sukses"] = true ;
          $data["pesan"] = "register berhasil";

         }
         else{
          $data["sukses"] = false ;
          $data["pesan"] = "register failed,try again";

         }
      }
      
      echo json_encode($data);
    }

    function login(){

     $email = $this->input->post("email");
     $password = $this->input->post("password");

     $this->db->where("user_email",$email);
     $this->db->where("user_password",md5($password));

     $hasil = $this->db->get("tb_user");

      //check query ada datanya apa enggak
      if($hasil -> num_rows() > 0 ){

          //bikin response k mobile
         $data['pesan'] = "login berhasil";
         $data['sukses']  = true ;
         $data['data'] = $hasil->row();
      }
      else{
       $data['pesan'] = "email atau password salah";
       $data['sukses']  = false ;
      }
      
      echo json_encode($data);
    }
}















