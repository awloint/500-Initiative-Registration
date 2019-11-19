'use strict'
google.maps.event.addDomListener(window, 'load', initialize)
function initialize () {
  var input = document.getElementById('location')
  var autocomplete = new google.maps.places.Autocomplete(input)
}

document.addEventListener('DOMContentLoaded', () => {
  const date = new Date()
  const year = date.getFullYear()
  const yearContent = document.querySelector('#year')
  yearContent.innerHTML = year

  // Add intl-tel-input
  window.intlTelInputGlobals.loadUtils('scripts/utils.js')
  var input = document.querySelector('#phone')
  window.intlTelInput(input, {
    initialCountry: 'ng',
    separateDialCode: true,
    hiddenInput: 'full_phone',
    utilsScript: 'scripts/utils.js'
  })

  const elems = document.querySelectorAll('select')
  const instances = M.FormSelect.init(elems)
  const count = document.querySelectorAll('textarea')
  M.CharacterCounter.init(count)

  const dob = document.querySelectorAll('.datepicker')
  const dateInstance = M.Datepicker.init(dob, {
    yearRange: [1905, 2001]
  })

  // Check if the user user already exists
  const email = document.querySelector('#email')

  email.addEventListener('change', e => {
    const emailAddress = email.value
    // console.log(emailAddress)
    // send it for processing
    axios
      .post('scripts/usercheck.php', {
        email: emailAddress
      })
      .then(response => {
        console.log(response.data)
        if (response.data === 'user_exists') {
          document.querySelector('#button').disabled = true
          swal(
            'Already Registered',
            'You have already registered for the event.',
            'warning'
          )
          setTimeout(() => {
            window.location = 'https://awlo.org/500'
          }, 3000)
        }
      })
      .catch(err => console.log('The Request has Failed', err))
  })

  //   Submit the form
  const form = document.querySelector('form')

  // On Form Submit
  form.addEventListener('submit', e => {
    // Check to see if form has validation errors
    if (form.checkValidity() === false) {
      e.preventDefault()
      e.stopPropagation()
    }

    // Get the referrer value from the URL
    const referrer = window.location.href.slice(
      window.location.href.indexOf('?') + 1
    )

    // If form doesn't have validation errors
    if (form.checkValidity() === true) {
      e.preventDefault()

      // change the button color and add the loading class
      //   document.querySelector('button').classList.remove('btn-danger')
      document.querySelector('#button').classList.add('btn-primary')
      document.querySelector('#button').innerHTML =
        'Loading <span class="spinner"><i class="fa fa-spinner fa-spin"></i></span>'

      // Grab the form data
      const formdata = new FormData(form)

      // Add the Referrer
      formdata.append('referrer', referrer)

      // send it for processing
      axios
        .post('scripts/processor.php', formdata)
        .then(response => {
          if (response.data === 'success') {
            swal(
              'Registration Successful!',
              'Your registration was successful.',
              'success'
            )
            setTimeout(() => {
              window.location = 'https://awlo.org/500'
            }, 4000)
          }
        })
        .catch(err => console.log('The Request has Failed', err))
    }
  })
})
