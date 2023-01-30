<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu {
    
    public function showMenu($permission){
        
        $showMenu['all_menu']  = "none";

        $showMenu['policy']    = "none";
        $showMenu['sop']       = "none";
        $showMenu['se']        = "none";
        $showMenu['sk']        = "none";
        $showMenu['memo']      = "none";

        if(in_array('view all', $permission)){
            $showMenu['all_menu'] = "show";
            $showMenu['policy'] = "show";
            $showMenu['sop'] = "show";
            $showMenu['sk'] = "show";
            $showMenu['se'] = "show";
            $showMenu['memo'] = "show";
        }

        if(in_array('view policy', $permission) OR in_array('admin policy', $permission)){
            $showMenu['policy'] = "show";
        }
        if(in_array('view sop', $permission) OR in_array('admin sop', $permission)){
            $showMenu['sop'] = "show";
        }
        if(in_array('view sk', $permission) OR in_array('admin sk', $permission)){
            $showMenu['sk'] = "show";
        }
        if(in_array('view se', $permission) OR in_array('admin se', $permission)){
            $showMenu['se'] = "show";
        }
        if(in_array('view memo', $permission) OR in_array('admin memo', $permission)){
            $showMenu['memo'] = "show";
        }

        return $showMenu;

    }

    


	
	
}
