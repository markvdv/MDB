//togglers verbergen
//checkbox refereren
var andereMagazinesCB = document.getElementById('create_model_form_andereMagazines');
console.log(andereMagazinesCB)
//input   andere magazines
var andereMagazinesZoekterm = document.getElementById('create_model_form_andereMagazinesZoekterm');
console.log(andereMagazinesZoekterm)
if (andereMagazinesCB.checked == false) {
  andereMagazinesZoekterm.style.display = "none";
} else {
  andereMagazinesZoekterm.style.display = "block";

}
andereMagazinesZoekterm.previousElementSibling.style.display = "none"
andereMagazinesCB.addEventListener('click', function () {
  console.log(andereMagazinesCB.checked);
  if (andereMagazinesCB.checked == true) {
    console.log(andereMagazinesZoekterm.style.display);
    andereMagazinesZoekterm.style.display = "block";
    andereMagazinesZoekterm.previousElementSibling.style.display = "block";
    console.log(andereMagazinesZoekterm.style.display);
  } else {
    andereMagazinesZoekterm.style.display = "none";
    andereMagazinesZoekterm.previousElementSibling.style.display = "none";
  }
})

$(document).ready(function () {
//<editor-fold defaultstate="collapsed" desc="cycle voor modelFotos">
  $('.modelItemCycle').cycle();
  //</editor-fold>
  //<editor-fold defaultstate="collapsed" desc="default values voor sliders en label texts">
  lengterange = [150, 200]
  $('#minlengte').text(lengterange[0])
  $('#maxlengte').text(lengterange[1])
  gewichtrange = [50, 100]
  $('#mingewicht').text(gewichtrange[0])
  $('#maxgewicht').text(gewichtrange[1])
  taillerange = [40, 90]
  $('#mintaille').text(taillerange[0])
  $('#maxtaille').text(taillerange[1])
  heuprange = [40, 90]
  $('#minheup').text(heuprange[0])
  $('#maxheup').text(heuprange[1])
  schoenmaatrange = [30, 50]
  $('#minschoenmaat').text(schoenmaatrange[0])
  $('#maxschoenmaat').text(schoenmaatrange[1])
  borstomtrekrange = [40, 100]
  $('#minborstomtrek').text(borstomtrekrange[0])
  $('#maxborstomtrek').text(borstomtrekrange[1])

  //</editor-fold>
  //<editor-fold defaultstate="collapsed" desc="slider instellingen">



  $("#lengteSlider").slider({
    range: true,
    values: lengterange,
    step: 5,
    min: lengterange[0],
    max: lengterange[1],
    change: function (event, ui) {
      console.log(ui.values);
      $('#minlengte').text(ui.values[0])
      $('#maxlengte').text(ui.values[1])
      lengterange = ui.values
    }
  })
  $("#gewichtSlider").slider({
    range: true,
    values: gewichtrange,
    step: 5,
    min: gewichtrange[0],
    max: gewichtrange[1],
    change: function (event, ui) {
      console.log(ui.values);
      $('#mingewicht').text(ui.values[0])
      $('#maxgewicht').text(ui.values[1])
      gewichtrange = ui.values
    }
  })
  $("#tailleSlider").slider({
    range: true,
    values: taillerange,
    step: 1,
    min: taillerange[0],
    max: taillerange[1],
    change: function (event, ui) {
      console.log(ui.values);
      $('#mintaille').text(ui.values[0])
      $('#maxtaille').text(ui.values[1])
      taillerange = ui.values
    }
  })
  $("#heupSlider").slider({
    range: true,
    values: heuprange,
    step: 1,
    min: heuprange[0],
    max: heuprange[1],
    change: function (event, ui) {
      console.log(ui.values);
      $('#minheup').text(ui.values[0])
      $('#maxheup').text(ui.values[1])
      heuprange = ui.values
    }
  })
  $("#borstomtrekSlider").slider({
    range: true,
    values: borstomtrekrange,
    step: 1,
    min: borstomtrekrange[0],
    max: borstomtrekrange[1],
    change: function (event, ui) {
      console.log(ui.values);
      $('#minborstomtrek').text(ui.values[0])
      $('#maxborstomtrek').text(ui.values[1])
      borstomtrekrange = ui.values
    }
  })
  $("#schoenmaatSlider").slider({
    range: true,
    values: schoenmaatrange,
    step: 1,
    min: schoenmaatrange[0],
    max: schoenmaatrange[1],
    change: function (event, ui) {
      console.log(ui.values);
      $('#minschoenmaat').text(ui.values[0])
      $('#maxschoenmaat').text(ui.values[1])
      schoenmaatrange = ui.values
    }
  })
//</editor-fold>

  //<editor-fold defaultstate="collapsed" desc="ajaxcall voor de lijst van modellen te veranderen">
  var ajaxButton = document.getElementById("create_model_form_zoek");
  if (typeof ajaxButton !== 'undefined') {
    ajaxButton.addEventListener('click', function () {
      $('#modellenOverzicht').html('');
      var dg = document.getElementById('loadingGif');
      dg.style.display = 'block';
      var rating = document.getElementById("create_model_form_rating_ratingNumber")
      var url = "search/minlengte=" + lengterange[0] + "&maxlengte=" + lengterange[1] + "&mingewicht=" + gewichtrange[0] + "&maxgewicht=" + gewichtrange[1] + "&mintaille=" + taillerange[0] + "&maxtaille=" + taillerange[1] + "&minheup=" + heuprange[0] + "&maxheup=" + heuprange[1] + "&minschoenMaat=" + schoenmaatrange[0] + "&maxschoenMaat=" + schoenmaatrange[1] + "&rating=" + rating.value
      var checkboxes = $('[type=checkbox]');
      //checkbox parameters toevoegen aan url 
      for (var i = 0; i < checkboxes.length; i++) {
        var id = checkboxes[i].id.replace("create_model_form_", "")
        var checked = checkboxes[i].checked
        if (checked === false) {
          checked = 0;
        }
        else {
          checked = 1;
          url += "&" + id + "=" + checked;
          if (id == "andereMagazines") {
            var andereMagazinesZoekterm = document.getElementById('create_model_form_andereMagazinesZoekterm').value;
            console.log(andereMagazinesZoekterm);
            url += "&andereMagazinesOmschrijving=" + andereMagazinesZoekterm;
          }
        }
      }
//selectparamters toevoegen aan url
      var selects = $('select')
      console.log(selects)
      for (var i = 0; i < selects.length; i++) {
        console.log(selects[i].value)
        if (selects[i].value !== '') {
          var id = selects[i].id.replace("create_model_form_", "")
          url += "&" + id + "=" + selects[i].value;
        }
      }
      console.log(url)
      $.ajax({
        url: url,
        context: $('#modellenOverzicht'),
      }).done(function (data) {
        var dg = document.getElementById('loadingGif');
        if (data.length == 0) {
          html = "No results found";
        }
        else {
          var html = '';
          for (var i in data) {
            html += "<table class='modelItem'>";
            html += "<tr ><td><div width='400px' height='400px' class='imgHolder modelItemCycle'>"
            for (var j = 0; j < data[i].fotos.length; j++) {
              html += "<img  src='../../uploads/documents/" + data[i].fotos[j].path + "'>";
            }
            html += "</div>"
            html += "</td><td> </td></td class='voornaam'> " + data[i].voornaam + "," + data[i].naam + "</td><td>" + data[i].geboorte_datum + "</td></tr>";
            html += "<th>contactinfo</th><tr><td>" + data[i].gsm + "</td><td>" + data[i].email + "</td></tr>";
            html += "<th>maten</th><tr><td>" + data[i].cup_maat + "</td>";
            html += "<td>" + data[i].lengte + "</td>";
            html += "<td>" + data[i].borst_omtrek + "</td>";
            html += "<td>" + data[i].confectie_maat + "</td>";
            html += "<td>" + data[i].gewicht + "</td></tr>";
            if (data[i].ervaring == true) {
              html += "<th>ervaring</th><tr><td>" + data[i].ervaring_omschrijving + "</td></tr>";
            }
            if (data[i].ratings.length !== 0) {
              var rating = 0
              for (var j = 0; j < data[i].ratings.length; j++) {
                rating += parseFloat(data[i].ratings[j].waarde);
              }
              rating = rating / data[i].ratings.length;
            }
            else {
              rating = "not rated yet";
            }
            html += "<tr><div>RATING: " + rating + "</div></tr>"
            html += "<tr><a href='rate/" + data[i].id + "'>RATE ME</a></tr>"
            html += '</table>'


            /*html += "<table  class='modelItem' border='1'>";
             html += "<tr ><td><div class='modelItemCycle'>"
             for (var j = 0; j < data[i].fotos.length; j++) {
             html += "<img width='200px' height='200px' src='../../uploads/documents/" + data[i].fotos[j].path + "'>";
             }
             html += "</div>"
             html += "</td><td> </td></td class='voornaam'> " + data[i].voornaam +","+data[i].naam+ "</td><td>" + data[i].geboorte_datum + "</td></tr>";
             html += "<th>contactinfo</th><tr><td>" + data[i].gsm + "</td><td>" + data[i].email + "</td></tr>";
             html += "<th>maten</th><tr><td>" + data[i].cup_maat + "</td>";
             html += "<td>" + data[i].lengte + "</td>";
             html += "<td>" + data[i].borst_omtrek + "</td>";
             html += "<td>" + data[i].confectie_maat + "</td>";
             html += "<td>" + data[i].gewicht + "</td></tr>";
             html += "<th>ervaring</th><tr><td>" + data[i].ervaring + "<td><td>" + data[i].ervaring_omschrijving + "<td></tr>";
             if (data[i].ratings.length !== 0) {
             var rating = 0
             for (var j = 0; j < data[i].ratings.length; j++) {
             rating += parseFloat(data[i].ratings[j].waarde);
             }
             rating = rating / data[i].ratings.length;
             }
             else {
             rating = "not rated yet";
             }
             html += "<div>RATING: " + parseFloat(rating) + "</div>"
             html += "<tr><a href='rate/" + data[i].id + "'>RATE ME</a></tr>"
             html += '</table>'*/

          }
        }
        $(this).html(html)
        $('.modelItemCycle').cycle();
        dg.style.display = 'none';
      }
      )
        .fail(function (request, status, error) {
          console.log(request);
          console.log(status);
          console.log(error);
        });
    })

  }
//</editor-fold>
//einde doc load
  //$('#taboverzicht a:eq(0)').tab()
  $('#taboverzicht a:eq(0)').tab(
    {active:1})
})



