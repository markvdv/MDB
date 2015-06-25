$(document).ready(
  function () {
    //eventlisteners voor dropdown buttons
    var redacteurDD = document.getElementById('redacteurDropdown');
    var redacteurItems = document.getElementById('redacteursExpandable');
    redacteurItems.style.display = "none"
    redacteurDD.addEventListener('click', function () {
      if (redacteurItems.style.display == "none") {
        redacteurItems.style.display = 'block'
      }
      else {
        redacteurItems.style.display = 'none'
      }
    })

    var modelDD = document.getElementById('modelDropdown');
    var modelItems = document.getElementById('modellenExpandable');
    modelItems.style.display = 'none'
    modelDD.addEventListener('click', function () {
      if (modelItems.style.display == "none") {
        modelItems.style.display = 'block'
      }
      else {
        modelItems.style.display = 'none'
      }
    })
    //eventlisteners voor edit knoppen
    $('.editModelButton').on('click', function (e) {
      var modelItemCycle = document.getElementsByClassName('modelItemCycle')[0]
      var saveButton = e.target.parentNode.getElementsByClassName('saveModelButton')[0]
      if (e.target.nextElementSibling.disabled === true) {
        $(modelItemCycle).cycle('destroy');
        e.target.parentNode.style.outline = '5px solid blue';
        e.target.nextElementSibling.disabled = false;
        e.target.nextElementSibling.nextElementSibling.disabled = false;
        saveButton.style.display = "block";
        saveButton.addEventListener('click', function () {
          console.log('saving action')
          //ajaxcall om model te bewerken
          var url = "../model/update/ajax/" + e.target.parentNode.id
          $.ajax({
            url: url,
            context: e.target.parentNode
          })
            .done(function (data) {
              console.log(data)
              //domtree updaten
              //database updaten
              this.innerHTML = "";
              var html = '<button class="imgHolder deleteButton" ><img src="../../bundles/modellenbundle/img/delete.png"></button>'
              html += '<button class="imgHolder editButton"><img src="../../bundles/modellenbundle/img/edit.png"></button>'
              html += '<button class="imgHolder saveButton" style="display:none"><img src="../../bundles/modellenbundle/img/save.png"></button>'
              html += '<input class="naam" value="' + data.naam + '" disabled>'
              html += '<input class="voornaam" value="' + data.voornaam + '" disabled>'
              html += '<div class="rating"> RATING</div>'
              html += '<div class="modelItemCycle imgHolder">'
              for (var i = 0; i < data.fotos; i++) {
                html += '<img alt="' + data.fotos[i].naam + ' title="' + data.fotos[i].naam + '" src="../../uploads/documents/' + data.fotos[i].path > +'">'
              }
              html += '</div></div>'
              this.innerHTMl = html;
            })
            .fail(function () {
              alert('oops')
            }

            )
        })
      }
      else {
        //cycle aanzetten
        e.target.parentNode.style.outline = '';
        e.target.nextElementSibling.disabled = true;
        e.target.nextElementSibling.nextElementSibling.disabled = true;
        saveButton.style.display = "none";
        $(modelItemCycle).cycle();
      }



    })
    $('.deleteModelButton').on('click', function (e) {
      //confirmationdialog
      var conf = confirm("are you sure you want to delete the model with id: " + e.target.parentNode.id + "? There is no going back afterwards!")
      if (conf === true) {//if true then delete 
        var url = "../model/delete/" + e.target.parentNode.id
        $.ajax({
          url: url,
          context: $('#modellenExpandable'),
        }).done(
          function (data) {
            e.target.parentNode.parentNode.removeChild(e.target.parentNode)
            alert(data)
          }
        )
          .fail(function (request, status, error) {
            alert('Ohoh! Something went wrong! Check the console')
            console.log("AJAX FAILED:")
            console.log("REQUEST: " + request);
            console.log("STATUS: " + status);
            console.log("ERROR: " + error);
          })
      }
    })

  }
)
$('.editRedacteurButton').on('click', function () {
  alert('edit redacteur');
})
$('.deleteRedacteurButton').on('click', function (e) {
  //confirmationdialog
  var conf = confirm("are you sure you want to delete the redacteur with id: " + e.target.parentNode.id + "? There is no going back afterwards!")
  if (conf === true) {//if true then delete 
    var url = "../redacteur/delete/" + e.target.parentNode.id
    $.ajax({
      url: url,
      context: $('#redacteursExpandable'),
    }).done(
      function (data) {
        e.target.parentNode.parentNode.removeChild(e.target.parentNode)
        alert(data)
      }
    )
      .fail(function (request, status, error) {
        alert('Ohoh! Something went wrong! Check the console')
        console.log("AJAX FAILED:")
        console.log("REQUEST: " + request);
        console.log("STATUS: " + status);
        console.log("ERROR: " + error);
      })
  }
})



