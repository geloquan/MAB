<?php

namespace App\Http\Controllers;

class PubViewController extends Controller {
  public function render() {
    return view('public.view');
  }
}
