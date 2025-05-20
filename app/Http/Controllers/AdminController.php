<?php

namespace App\Http\Controllers;

class AdminController extends Controller {
  public function render() {
    return view('admin.index');
  }
}
