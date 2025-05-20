<?php

namespace App\Models; // Or wherever you prefer to place this class

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DoctorResource {

  protected static $doctor_resources = null;

  /**
   * Get all specializations
   *
   * @return array
   */
  public static function all(): array {
    $resource = DB::table('doctor_resource')->get()->toArray();
    self::$doctor_resources = $resource;

    return $resource;
  }
  /**
   * Get a specific doctor resource by ID.
   *
   * @param int $id
   * @return object|null
   */
  public static function get($id) {
    return self::$doctor_resources->firstWhere('doctor_id', $id);
  }
}