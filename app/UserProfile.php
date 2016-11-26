<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

  protected $table = 'user_profiles';
  public $primaryKey  = 'user_id';

  protected $fillable = [
    'fullname', 'country_id', 'city', 'birthdate', 'sex', 'phone', 'description', 'image',
    'social_facebook', 'social_twitter', 'social_youtube', 'social_instagram',
    'social_snapchat', 'former_id'
  ];

  public function getFullNameAttribute($value)
  {
      return html_entity_decode(strip_tags($value));
  }

  public function user(){
      return $this->belongsTo('App\User');
  }
}
