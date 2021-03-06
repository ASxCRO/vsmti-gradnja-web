<!DOCTYPE html>
<html lang="en" ng-app="skladisteModule">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="author" content="ASxCRO">
  <meta name="keywords" content="Gradnja, Visokogradnja, Niskogradnja, Građevinske usluge">
  <meta name="description" content="Gradite kuću? Vaš pravi izbor je VŠMTI GRADNJA d.o.o. !">
  <meta name="robots" content="all">
  <link rel="stylesheet" href="./fonts/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="./bundle/animateCSS/animate.min.css">
  <link rel="stylesheet" type="text/css" href="./bundle/semanticUI/dist/semantic.min.css">
  <link rel="stylesheet" href="./bundle/dataTables/datatables.min.css">
  <link rel="stylesheet" href="./bundle/dataTables/DataTables-1.10.21/css/dataTables.semanticui.min.css">
  <link rel="stylesheet" href="./bundle/dataTables/DataTables-1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/skladiste.css">
  <link rel="stylesheet" href="./css/dodajDokument.css">
<style>
  .flex-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  flex-wrap: wrap;
  margin:  0;
}

.text-align {
  text-align:center;
}
</style>
  <link rel="stylesheet" media="screen and (max-width:768px)" href="./css/mobile.css">
  <title>VŠMTI GRADNJA | Visokogradnja, Niskogradnja, i usluge!</title>
</head>

<body ng-controller="skladisteController">

  <!-- Navbar -->
  <navbar-skladiste></navbar-skladiste>
  <?php 
session_start();
if(isset($_SESSION['login'])) { 

echo'  <section id="showcase">
    <div class="showcase-content-skladiste">
      <section id="tabs" class="py-3 text-primary">
          <div class="ui top attached tabular menu">
            <a class="item active" data-tab="first">Novi Dokument</a>
            <a class="item" data-tab="second" id="primkaTabHeader">Nova primka</a>
            <a class="item" data-tab="third" id="izdatnicaTabHeader">Nova izdatnica</a>
          </div>
          <div class="ui bottom attached tab segment active" data-tab="first" id="skladisteTabContent">
            
            <div class="flex-container">
              <div class="home-header">
                <h2 class="l-heading">Novi dokument</h2>
              </div>
              <a onclick="RedirectToNewPrimka()" class="btn btn-primary btn-lg">Nova primka</a>
              <a onclick="RedirectToNewIzdatnica()" class="btn btn-primary btn-lg">Nova izdatnica</a>
            </div>
          </div>
          <div class="ui bottom attached tab segment" data-tab="second" id="primkaTabContent">
            <div class="header">
              <h2 class="l-heading">Dodaj novu primku</h2>
              <div class="plus-icon" ng-click="dodajArtiklNaDokument(\'primka\')"><i class="fas fa-plus-circle fa-5x"></i><span> Dodaj Artikl</span></div>
            </div>

            <hr>
            <form action="#">
                <div class="articles-list" id="artikliPrimke">
                  <div class="article" ng-repeat="article in artikliNaDokumentuPrimke track by $index " >
                    <p>{{article.m_naziv}}</p>
                    <table>
                      <thead>
                        <tr>
                          <th>Količina</th>
                          <th>Cijena</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <td>
                              <div class="ui right labeled input">
                                <label for="amount" class="ui label">{{article.m_jmj}}</label>
                                <input type="text" class="money" placeholder="Kolicina" id="amount" ng-model="kolicina[$index]">
                              </div>
                            </td>
                            <td>{{convertToMoney(article.m_cijena * kolicina[$index])}} HRK</td>
                          </tr>
                      </tbody>
                    </table>
                    <div class="kolicina">
                      <button class="ui primary button" ng-click="deleteArticleFromList(article.m_id)">
                        Izbriši
                      </button>
                    </div>
                  </div>
                </div>
                <div class="ui left action input">
                  <button class="ui  labeled icon button">
                    <i class="cart icon"></i>
                    Iznos
                  </button>
                  <p class="l-heading" id="total" style="margin-left: 1rem"> {{convertToMoney(getTotal(artikliNaDokumentuPrimke)) || 0}} HRK</p>
                </div>
                <a class="btn btn-primary btn-lg"><div class="plus-icon-add" ng-click="modalZaSpremanjeDokumenta(\'0\')"><i class="fas fa-plus-circle fa-5x"></i></div></a>
            </form>
            <hr>
          </div>
          <div class="ui bottom attached tab segment" data-tab="third" id="izdatnicaTabContent">
            <div class="header">
              <h2 class="l-heading">Dodaj novu izdatnicu</h2>
              <div class="plus-icon" id="primkaDocSave" ng-click="dodajArtiklNaDokument(\'izdatnica\')"><i class="fas fa-plus-circle fa-5x"></i><span> Dodaj Artikl</span></div>
            </div>

            <hr>
            <form action="#">
              <div class="articles-list" id="artikliIzdatnice">
                <div class="article" ng-repeat="article in artikliNaDokumentuIzdatnice track by $index " >
                  <p>{{article.m_naziv}}</p>
                  <table>
                    <thead>
                      <tr>
                        <th>Količina</th>
                        <th>Cijena</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                            <div class="ui right labeled input">
                              <label for="amount" class="ui label">{{article.m_jmj}}</label>
                              <input type="text" class="money" placeholder="Kolicina" id="amount" ng-model="kolicina[$index]">
                              <!-- <input type="text" name="kolicina" id="amount" mask="999,999,999.99" clean="false" ng-model="kolicina[$index]"> -->
                            </div>
                          </td>
                          <td>{{convertToMoney(article.m_cijena * kolicina[$index])}} HRK</td>
                        </tr>
                    </tbody>
                  </table>
                  <div class="kolicina">
                    <button class="ui primary button" ng-click="deleteArticleFromList(article.m_id)">
                      Izbriši
                    </button>
                  </div>
                </div>
              </div>
              <div class="ui left action input">
                <button class="ui  labeled icon button">
                  <i class="cart icon"></i>
                  Iznos
                </button>
                <p class="l-heading" style="margin-left: 1rem"> {{convertToMoney(getTotal(artikliNaDokumentuIzdatnice))}} HRK</p>
              </div>
              <a class="btn btn-primary btn-lg"><div class="plus-icon-add" ng-click="modalZaSpremanjeDokumenta(\'1\')"><i class="fas fa-plus-circle fa-5x"></i></div></a>
            </form>
            <hr>
          </div>
      </section>
    </div>
  </section>';
}
else {
  echo '
  <section id="showcase">
  <div class="showcase-content-skladiste">
  <section id="tabs" class="text-primary">
  <div class="ui top attached tabular menu">
  <a class="item active" data-tab="first">Skladište</a>
  </div>
  <div class="ui bottom attached tab segment active" data-tab="first" id="skladisteTabContent">
  
  <div class="flex-container">
  <div class="home-header">
  <h2 class="l-heading">Da bi pristupili skladištu, morate se prijaviti.</h2>
  </div>
<a href="./sign.html" class="btn btn-primary btn-lg">Prijava</a>
</div>
</div>
</section>
</div>
</section>';
}

?>
  <div class="ui basic modal">
    <div class="ui icon header">
      <i class="archive icon"></i>
      Jeste li sigurni da želite spremiti dokument sa upisanim podatcima?
    </div>
    <div class="content text-align">
      <p>Nije moguće zaustaviti spremanje!</p>
    </div>
    <div class="actions">
      <div class="ui red basic cancel inverted button">
        <i class="remove icon"></i>
        Ne
      </div>
      <div class="ui blue ok inverted button">
        <i class="checkmark icon"></i>
        Da
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer id="footer" class="bg-light text-center">
    <p>Copyright &copy; 2020, ASXCRO. All Rights Reserved.</p>
  </footer>


  
  <div id="scripts">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        jQuery(function($){
          $.datepicker.regional['hr'] = {
            closeText: 'Zatvori',
            prevText: 'Prethodni mjesec',
            nextText: 'Slijedeći mjesec',
            currentText: 'Danas',
            monthNames: ['Siječanj','Veljača','Ožujak','Travanj','Svibanj','Lipanj',
            'Srpanj','Kolovoz','Rujan','Listopad','Studeni','Prosinac'],
            monthNamesShort: ['Sij.','Velj.','Ožu.','Tra.','Svi.','Lip.',
            'Srp.','Kol.','Ruj.','Lis.','Stu.','Pro.'],
            dayNames: ['Nedjelja','Ponedjeljak','Utorak','Srijeda','Četvrtak','Petak','Subota'],
            dayNamesShort: ['Ned.','Pon.','Uto.','Sri.','Čet.','Pet.','Sub.'],
            dayNamesMin: ['N','P','U','S','Č','P','S'],
            weekHeader: 'Tjedan',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
          $.datepicker.setDefaults($.datepicker.regional['hr']);
        });
    </script>
    <script src="./bundle/jquery/jquery.mask.js"></script>
  
    <!-- AngularJS -->
    <script src="./bundle/angularJS/angular.min.js"></script>
    <script src="./bundle/angularJS/angular-route.min.js"></script>
  
    <!-- DataTables PlugIn -->
    <script src="./bundle/dataTables/DataTables-1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="./bundle/dataTables/DataTables-1.10.21/js/dataTables.semanticui.min.js"></script>
  
    <!-- Semantic UIJS -->
    <script src="./bundle/semanticUI/dist/semantic.min.js"></script>
  
    <!-- Globals -->
    <script src="./js/globals.js"></script>
    <!-- Local JS  -->
    <script src="./js/skladiste.js"></script>
  </div>
  
</body>

</html>