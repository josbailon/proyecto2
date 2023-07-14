$('.error-page, .success-page').hide(0);

$('.register-button').click(function(){
  var username = $('#username').val();
  var password = $('#password').val();

  if (username && password) {
    // Simulación de registro exitoso
    $('.login').slideUp(500);
    $('.success-page').slideDown(1000);
  } else {
    // Simulación de error en el registro
    $('.login').slideUp(500);
    $('.error-page').slideDown(1000);
  }
});

$('.try-again').click(function(){
  $('.error-page').hide(0);
  $('.login').slideDown(1000);
});

$('.sign-in').click(function(){
  $('.error-page, .success-page').hide(0);
  $('.login').slideDown(1000);
});
$('.login-button').click(function(){
    // Lógica para el inicio de sesión
  });
  
  $('.sign-up').click(function() {
    window.location.href = 'registro.html';
  });
  
  $('.no-access').click(function() {
    // Lógica para recuperar cuenta
  });
  