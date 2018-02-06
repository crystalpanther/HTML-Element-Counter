/* global windows, staticOut */

var windows = $('.window'); // get the output for counting elements
var staticOut = $('#content'); // get the output for statistics

//create the constructor for ajax and define ajax function
function ajaxSend (urlSend, output, method) {

  var url = $('#url').val(); //value from url input
  var htmlElement = $('#htmlElement').val(); // value from HTML input
  var domain;
  domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img); // regexp for pick out domain name

  if (domain) domain = domain[0]; //define domain string only if url is available

  var formData;
  formData = {
    'url': url,
    'htmlElement': htmlElement,
    'domain': domain
  };
  this.sendData = function() {
    $.ajax({
      url: urlSend, //where data send
      type: method, //POST or GET
      data: formData, //data
      timeout: 10000, //timeout for ajax script
      beforeSend: function () { // visualization for waiting before script will end
        $('.loader').addClass('visible'); //make loader visible
      },
      headers: {
        'Access-Control-Allow-Origin': '*' //access CORS
      },
      success: function (data) {
        output.html(data); //return data from parsing.php
      },
      error: function(textStatus, XHR) {
        console.log(XHR + ' ' + textStatus); //if something wrong the console will show
        output.text('Sorry, something wrong. Please, try again'); //
      },
      complete : function() {
        $('.loader').removeClass('visible'); // make loader hidden
      }
    });
  };
}

//define the script for form validation
function checkInput() {

  var url = $('#url');
  var element = $('#htmlElement');


  if (url.val() === '') { //check URL input value
    url.addClass('red'); //add CSS style if it not
    $('#error-url').text('Please add URL address'); //show the message
    return false;
  }
  else if (!url.val().match(/^[a-zA-Z]+:\/\//)) { //check if URL address correct
    url.addClass('red');
    $('#error-url').text('Please add correct URL address (http:// or https://) ');
    return false;
  }
  else if (element.val() === '') { //check html element input value
    element.addClass('red');
    $('#error-tag').text('Please add tag');
    return false;
  }
  return true; //if all inputs are available return true
}


//hang an event on the buttons
$('#getUrl').on('click', function count () {
  checkInput(); //validate form
  if (checkInput() === true) {
    $('input').each(function(){
      if($(this).hasClass('red')); { //remove CSS style for the input if validation is OK
        $(this).removeClass('red');
      }
    });
    $('.error-msg').text('');
    var countElem = new ajaxSend('php/parsing.php', windows, 'POST'); //create new object for get count
    countElem.sendData(); //if validation is OK run the script
  }
});
$('#getStat').on('click', function statistics() {
  checkInput(); //validate form
  if (checkInput() === true) {
    $('input').each(function(){
      if($(this).hasClass('red')) { //remove CSS style for the input if validation is OK
        $(this).removeClass('red');
      }
    });
    $('.error-msg').text('');
    var getStatistics = new ajaxSend('php/dataBase.php', staticOut, 'GET'); //create new object for get statistics
    getStatistics.sendData();
  }
});
$('#reset').on('click', function reset() {
  $('input').each(function(){
    if($(this).hasClass('red')) { //remove CSS style for the input if validation is OK
      $(this).removeClass('red');
      $('.error-msg').text('');
    }
  });
  windows.text('');
  staticOut.text('');
});
