<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
  protected $table = 'availability';

  protected $fillable = [
      'user_id',
      'date',
      'time_slot_id',
      'available',
  ];

  protected $dates = ['created_at', 'updated_at'];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function timeSlot()
  {
      return $this->belongsTo('App\TimeSlot');
  }

  public function getDateAttribute($date)
  {
      $date = Carbon::createFromFormat('Y-m-d', $date);

      return $date;
  }

  public function setDateAttribute($date)
  {
      $this->attributes['date'] = $date->format('Y-m-d');
  }
}
