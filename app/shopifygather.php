<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shopifygather extends Model
{
  protected $table = 'shopify_gather';

  protected $fillable = ['message'];

  public $timestamps = false;


}
