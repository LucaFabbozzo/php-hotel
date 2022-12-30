<!-- Descrizione
Partiamo da questo array di hotel. https://www.codepile.net/pile/OEWY7Q1G
Stampare tutti i nostri hotel con tutti i dati disponibili.
Iniziate in modo graduale.
Prima stampate in pagina i dati, senza preoccuparvi dello stile.
Dopo aggiungete Bootstrap e mostrate le informazioni con una tabella.
Bonus:
1 - Aggiungere un form ad inizio pagina che tramite una richiesta GET permetta di filtrare gli hotel che hanno un parcheggio.
2 - Aggiungere un secondo campo al form che permetta di filtrare gli hotel per voto (es. inserisco 3 ed ottengo tutti gli hotel che hanno un voto di tre stelle o superiore)
NOTA: deve essere possibile utilizzare entrambi i filtri contemporaneamente (es. ottenere una lista con hotel che dispongono di parcheggio e che hanno un voto di tre stelle o superiore)
Se non viene specificato nessun filtro, visualizzare come in precedenza tutti gli hotel.
Usiamo la logica con le nozioni che abbiamo fino ad ora senza cercare possibilità di filtri più evoluti che vedremo domani -->



<?php

    $hotels = [

        [
            'name' => 'Hotel Belvedere',
            'description' => 'Hotel Belvedere Descrizione',
            'parking' => true,
            'vote' => 4,
            'distance_to_center' => 10.4
        ],
        [
            'name' => 'Hotel Futuro',
            'description' => 'Hotel Futuro Descrizione',
            'parking' => true,
            'vote' => 2,
            'distance_to_center' => 2
        ],
        [
            'name' => 'Hotel Rivamare',
            'description' => 'Hotel Rivamare Descrizione',
            'parking' => false,
            'vote' => 1,
            'distance_to_center' => 1
        ],
        [
            'name' => 'Hotel Bellavista',
            'description' => 'Hotel Bellavista Descrizione',
            'parking' => false,
            'vote' => 5,
            'distance_to_center' => 5.5
        ],
        [
            'name' => 'Hotel Milano',
            'description' => 'Hotel Milano Descrizione',
            'parking' => true,
            'vote' => 2,
            'distance_to_center' => 50
        ],

    ];

    //di default l'elenco filtrato che circlero' in pagina comprende tutto l'array
    $filteredhotels = $hotels;

  //   // var_dump($_SERVER);
  //   //var_dump($_GET);


  //MODALITA' SENZA FUNZIONI
  //   // verifico se è presnte il dato in $_GET['parking']


  //   if(!empty($_GET['parking'])) {
  //     // creare array temporaneo dove salvare l'array filtrato
  //     $temp_hotels = [];
  //     // ciclare tutto l'array e pushare nell'array temp solo gli hotel che hanno il parcheggio
  //     foreach ($filteredhotels as $hotel) {
  //       if ($hotel['parking']) $temp_hotels[] = $hotel;
  //       }
  //     //sostituire $filteredhotels con l'array temporaneo
  //     $filteredhotels = $temp_hotels;
  //   }

  //   //se ho scelto senza parcheggio verifico l'esistenza del parametro parking in GET e che sia pero' vuoto
  //     if(isset($_GET['parking']) && empty($_GET['parking'])) {
  //     // creare array temporaneo dove salvare l'array filtrato
  //     $temp_hotels = [];
  //     // ciclare tutto l'array e pushare nell'array temp solo gli hotel che NON hanno il parcheggio
  //     foreach ($filteredhotels as $hotel) {
  //       if (!$hotel['parking']) $temp_hotels[] = $hotel;
  //       }
  //     //sostituire $filteredhotels con l'array temporaneo
  //     $filteredhotels = $temp_hotels;
  //   }



  //  if(!empty($_GET['vote'])) {
  //    $temp_hotels = [];

  //      foreach ($filteredhotels as $hotel) {
  //       //pusho l'elemento solo se il voto è >= di quello che mi arriva in GET
  //       if ($hotel['vote'] >= $_GET['vote']) $temp_hotels[] = $hotel;
        
  //       }

  //    $filteredhotels = $temp_hotels;
  //  }


  //MODALITA' CON array_filter senza arrow function
// array_filter() è una funzione predefinita in PHP che consente di filtrare gli elementi di un array in base a una determinata condizione. La funzione accetta come argomenti l'array da filtrare e una funzione di callback, che viene utilizzata per determinare quali elementi dell'array devono essere mantenuti.

// Vengono definite due funzioni di callback, checkParking() e checkVote(), che verranno utilizzate da array_filter() per filtrare gli elementi di $filteredhotels in base alla presenza di parcheggio o al voto.

// Infine, viene controllato se l'URL contiene il parametro parking o il parametro vote. Se presente, viene utilizzata la funzione array_filter() per filtrare gli elementi di $filteredhotels utilizzando la funzione di callback appropriata.

// Se ad esempio l'URL è http://example.com?parking=true, verranno mantenuti solo gli elementi di $filteredhotels che hanno il campo parking impostato su true. Se invece l'URL è http://example.com?vote=3, verranno mantenuti solo gli elementi di $filteredhotels che hanno il campo vote maggiore o uguale a 3.

  function checkParking($hotel) {
    return $hotel['parking'] == $_GET['parking'];
  }


  function checkVote($hotel) {
    return $hotel['vote'] >= $_GET['vote'];
  }

  if(!empty($_GET['parking']) || (isset($_GET['parking']) && empty($_GET['parking']))) {
    $filteredhotels = array_filter($filteredhotels, 'checkParking');
  }


   if(!empty($_GET['vote'])) {
    $filteredhotels = array_filter($filteredhotels, 'checkVote');
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <title>PHP Hotel</title>
</head>
<body>

  <style>
    body {
      font-family: 'Lato', sans-serif;
    }
  </style>

<!-- con $_SERVER['PHP_SELF'] faccio puntare il form alla pagina stessa senza dovere scrivere il nome del file -->

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" class="row gx-3 gy-2 py-2 m-3 align-items-center ">

    <div class="col-sm-3">
        <input class="form-check-input" type="radio" name="parking" id="parking1" value="">
        <label class="form-check-label" for="parking1">
        senza parcheggio
        </label>
        <input class="form-check-input" type="radio" name="parking" id="parking2" value="1">
        <label class="form-check-label" for="parking2">
          con parcheggio
        </label>
    </div>

    <div class="col-sm-3">
        <label for="vote">Voto</label>
        <input type="number" name="vote" id="vote">
    </div>

    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Cerca</button>
      <button type="reset" class="btn btn-secondary">Annulla</button>
    </div>

</form>

<table class="table table-striped m-3">
  <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">Descrizione</th>
      <th scope="col">Parcheggio</th>
      <th scope="col">stelle</th>
      <th scope="col">Distanza dal centro</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($filteredhotels as $hotel):?>
    <tr>
      <th scope="row"><?php echo $hotel['name'] ?></th>
      <td><?php echo $hotel['description'] ?></td>
      <td><?php echo $hotel['parking'] ? 'Si' : 'No' ?></td>
      <td><?php echo $hotel['vote'] ?></td>
      <td><?php echo $hotel['distance_to_center'] ?></td>
    </tr>
     <?php endforeach; ?>
  </tbody>
</table>

</body>
</html>