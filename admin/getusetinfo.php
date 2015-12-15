<?php

require_once('../mysqli_connect.php');

$query= "SELECT email, password, type, created
          FROM users";

$response = mysqli_query($dbc, $query);

if($response){
    echo '<table align="left" cellspacing="5" cellpadding="8">

            <tr>
            <td align="left"><b>Email</b></td>
            <td align="left"><b>Password</b></td>
            <td align="left"><b>Type</b></td>
            <td align="left"><b>Created</b></td>

            </tr>';

            while($row = mysqli_fetch_array($response)){

                echo '<tr><td align="left">' .
                $row['email']. '</td><td align="left">' .
                $row['password']. '</td><td align="left">' .
                $row['type']. '</td><td align="left">' .
                $row['created']. '</td><td align="left">' .


                    '</td></tr>';

            }
    echo '</table>';

}else{
    echo "Could't issue database query";
    echo mysqli_error($dbc);
}

mysqli_close($dbc);