'use strict'
document.addEventListener('DOMContentLoaded', e => {
  let date = new Date()
  const year = date.getFullYear()
  let yearContent = document.querySelector('#year')
  yearContent.innerHTML = year

  // Get the referrer value from the URL
  const referrer = window.location.href.slice(
    window.location.href.indexOf('?') + 1
  )

  let formdata = JSON.stringify({ referrer: referrer })

  // initiate a fetch call
  axios
    .post('scripts/display.php', formdata)
    .then(data => {
      console.log(data)
    //   for (var i = 0; i < data.length; i++) {
    //     $('#data').append(
    //       '<tr><td>' +
    //         data[i].id +
    //         '</td><td>' +
    //         data[i].firstName +
    //         '</td><td>' +
    //         data[i].lastName +
    //         '</td><td>' +
    //         data[i].email +
    //         '</td><td>' +
    //         data[i].phone +
    //         '</td><td>' +
    //         data[i].country +
    //         '</td><td>' +
    //         data[i].occupation +
    //         '</td><td>' +
    //         data[i].organisation +
    //         '</td><td>' +
    //         data[i].member +
    //         '</td><td>' +
    //         data[i].referringChannel +
    //         '</td><td>' +
    //         data[i].firstConference +
    //         '</td><td>' +
    //         data[i].referrer +
    //         '</td><td>' +
    //         data[i].created_at +
    //         '</td><td>' +
    //         data[i].paid +
    //         '</td><td>' +
    //         data[i].paid_at +
    //         '</td></tr>'
    //     )
    //   }
    })
    .catch(error => {
      console.log('The Request Failed', error)
    })
})
