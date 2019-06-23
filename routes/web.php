<?php

Route::group(['middleware' => 'maintenance'], function () {

  Route::get('/', function () {
      return view('style.home');
  });

});

Route::get('maintenance', function(){

  if(setting()->status == 'open') {
      return redirect('/');
  }

  return view('style.maintenance');
});
