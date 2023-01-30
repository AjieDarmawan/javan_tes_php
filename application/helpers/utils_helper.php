<?php

function get_payload() {
  return json_decode(file_get_contents('php://input'), TRUE);
}

function response($data = NULL, $http_code = NULL) {
  $ci = &get_instance();
  $ci->output
        ->set_status_header($http_code)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($data))
        ->_display();
      exit;
}