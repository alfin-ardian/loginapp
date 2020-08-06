<?php


function is_logged_in()
{
    $login = get_instance();
    if (!$login->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $login->session->userdata('role_id');
        $menu = $login->uri->segment(1);

        $queryMenu = $login->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $login->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
