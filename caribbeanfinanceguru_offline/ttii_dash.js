let checkedOptions = [];
$(window).on('load', function() {
  var maxChoices = 3;

  $('input[type=checkbox]').on('change', function(evt) {
    if ($('input[type=checkbox]:checked').length > maxChoices) {
      $(this).prop('checked', false);
      alert('You can only select up to ' + maxChoices + ' tasks.');
    }
  });

  $('#chapter_select_form').on('submit', function(evt) {
    evt.preventDefault();
    const checkedOptions = [];
    const checkboxes = $(this).find('.checked_option');

    checkboxes.each(function() {
      if (this.checked) {
        checkedOptions.push(this.value);
      }
    });

    let chaptersChoice = JSON.stringify(checkedOptions);
    sessionStorage.setItem('checkedOptions', chaptersChoice);

    let redirectUrl = 'ttii_quiz.php';
    redirectUrl += '?chaptersChoice=' + encodeURIComponent(chaptersChoice);
    window.location.href = redirectUrl;

  });
});

/*
$('#chapter_select_form').on('submit', function(evt) {
  evt.preventDefault();
  const checkedOptions = [];
  const checkboxes = $(this).find('.checked_option');

  checkboxes.each(function() {
    if (this.checked) {
      checkedOptions.push(this.value);
    }
  });

  if (checkedOptions.length > 3) {
    alert('You can only select up to 3 tasks.');
    return;
  }

  let chaptersChoice = JSON.stringify(checkedOptions);
  sessionStorage.setItem('checkedOptions', chaptersChoice);

  let redirectUrl = 'http://localhost/dev-healthyfinancecheck/ttii_quiz.php';
  redirectUrl += '?chaptersChoice=' + encodeURIComponent(chaptersChoice);
  window.location.href = redirectUrl;
});
*/
