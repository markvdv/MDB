$(document).ready(function () {
//inputs op de pagina disablen
  $('input').prop("disabled", true);



//eventlisteners voor edit knoppen
//als de edit button wordt geklikt checken we of de inputs van het bijbehorende element enabled of disabled zijn, op basis daarvan maken we dan een ajax call

  $('.editModelButton').on('click', function (e) {
    var edit = toggleInputs(e)
    var modelid = e.target.parentNode.getAttribute('name');
    //opslaan indien terug disabled
    if (edit == true) {
//ajaxcall om model te updaten
      var url = "../model/update/ajax/" + modelid + "/"
      var inputs = e.target.parentNode.getElementsByTagName('input');
      for (var i in inputs) {
        if (typeof inputs[i].id !== "undefined") {
          var inputid = inputs[i].id.replace("create_model_form_", "")
          if (inputid.match("_")){
            console.log("id needs further editing")
            var arr=inputid.split('_')
            inputid=arr[arr.length-1]
          }
          url += inputid + "=" + inputs[i].value + "&"
        }
      }
     url= url.slice(0, -1)
      console.log(url)
      $.ajax({
        url: url
      })
        .done(function (data) {
          console.log(data.adres)
          alert('profile updated')
        })
        .fail(function (request, status, error) {
          console.log(request);
          console.log(status);
          console.log(error);
        });
    }
  })

  function toggleInputs(e) {
    var editMode = false;
    //originale navigatie stoppen
    e.preventDefault()
    console.log(e.target)
    //parentNosde iophalen en alle child inputs enabled
    var inputs = e.target.parentNode.parentNode.getElementsByTagName('input');
    console.log(inputs)
    for (var i in inputs) {
      if (inputs[i].disabled == true) {
        inputs[i].disabled = false;
      }
      else {
        inputs[i].disabled = true
      }
      if (inputs[0].disabled == true) {
        editMode = true
      }
    }
    return editMode;
  }
})
