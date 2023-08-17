<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    
    #customers tr:nth-child(even){background-color: #f2f2f2;}
    
    #customers tr:hover {background-color: #ddd;}
    
    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
</style>
<title>Visitor Reservations</title>
</head>
<body onload="window.print();">
<table id="customers">
  <tr>
    <th>ID</th>
    <th>Visitor Name</th>
    <th>Arrival Date</th>
    <th>Safari Start Date</th>
    <th>Safari End Date</th>
    <th>Car Number</th>
    <th>Guide Name</th>
    <th>Special Event</th>
  </tr>
  <!-- Replace this section with actual data from your PHP loop -->
  @foreach ($results as $reserve)
      <tr class="hover:bg-blue-300 {{ ($loop->even ) ? " bg-blue-100" : "" }}">
        <td class="px-3 py-2">{{ $reserve->id }}</td>
        <td class="px-3 py-2 capitalize">{{ $reserve->visitorName }}</td>
        <td class="px-3 py-2 capitalize">{{ $reserve->arrivalDate  }}</td>
        <td class="px-
        3 py-2">{{ $reserve->safariStartDate }}</td>
        <td class="px-
        3 py-2">{{ $reserve->safariEndDate }}</td>
        <td class="px-
        3 py-2">{{ $reserve->carNumber }}</td>
        <td class="px-
        3 py-2">{{ $reserve->guideName  }}</td>
        <td class="px-
        3 py-2">{{ $reserve->specialEvent }}</td>

    </tr>
    @endforeach
  <!-- Repeat this row for each data entry -->
</table>
</body>
</html>
