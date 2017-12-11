<?php
	echo("<!DOCTYPE html>");
	echo("<html>");
		echo("<head>");
			echo("<title>Ricerca</title>");
			echo("<link rel='stylesheet' type='text/css' href='style.css'>");
			echo("<script>");
				echo("function controllo_campi()
				{
					var valore=document.getElementById('num').value;
					var esito=false;
					var verifica=/^\d{1,2}$/
					if(document.getElementById('num').value!=''&&document.getElementById('cit').value!=''&&document.getElementById('que').value!='');
						if(valore.match(verifica)&&parseInt(valore)<51)
							esito=true;
					return esito;
				}");
			echo("</script>");
		echo("</head>");
		echo("<body>");
			
				if(isset($_POST["num"]))
					$num=$_POST["num"];
				else
					$num=10;
				
				if(isset($_POST["cit"]))
				{
					$cit=$_POST["cit"];
					echo $cit;
				}
				else
					$cit="bergamo";
				
				if(isset($_POST["que"]))
					$que=$_POST["que"];
				else
					$que="pizzeria";
				
				# Questo script chiama un'API e la inserisce in una tabella
				# Indirizzo dell'API da richiedere
				$indirizzo_pagina="https://api.foursquare.com/v2/venues/search?v=20161016&query=$que&limit=$num&intent=checkin&client_id=QYSXXCRU2SZW1VWKLTQFFPCAXNHFCTEG40KDX1NGH2TOKNT5&client_secret=QZO3O23TLTPFFYDRVPEBEWEO1UBAO5EZ0I1Y11P4YXO0PLWC&near=$cit";
				
				# Codice di utilizzo di cURL
				# Chiama l'API e la immagazzina in $json
				$ch = curl_init() or die(curl_error());
				curl_setopt($ch, CURLOPT_URL,$indirizzo_pagina);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$json=curl_exec($ch) or die(curl_error());
				
				# Decodifico la stringa json e la salvo nella variabile $data
				$data = json_decode($json);
				
				# Controllo valori
				if (count($data->response->venues)<$num);
					$num=count($data->response->venues);
				
				# Stampa della tabella delle pizzerie.
				if($num!=0)
				{
					echo("<table>");
						echo("<tr>");
							echo("<th>NOME</th>");
							echo("<th>LATITUDINE</th>");
							echo("<th>LONGITUDINE</th>");
						echo("</tr>");
						for($i=0; $i<$lim; $i++)
						{
							echo("<tr>");
								echo("<td>");
								echo $data->response->venues[$i]->name;
								echo("</td>");
								echo("<td>");
								echo $data->response->venues[$i]->location->lat;
								echo("</td>");
								echo("<td>");
								echo $data->response->venues[$i]->location->lng;
								echo("</td>");
							echo("</tr>");
						}
					echo("</table>");
				}
				else
					echo("ERRORE, NON SONO STATE TROVATE CORRISPONDENZE CON I CAMPI SELEZIONATI!");
				# Stampa di eventuali errori
				echo curl_error($ch);
				curl_close($ch);

				echo("<form id='forma' method='post' onsubmit='return controllo_campi();'><br/>");
				echo("<table>");
				echo("<tr>");
				echo("<td>Numero elementi (1-50): </td><td><input type='text' value='$num' name='num'id='num' /></td>");
				echo("</tr>");
				echo("<tr>");
				echo("<td>Citta: </td><td><input type='text' value='$cit' name='cit' id='cit' /></td>");
				echo("</tr>");
				echo("<tr>");
				echo("<td>Cosa stai cercando?: </td><td><input type='text' value='$que' name='que' id='que' /></td><br/>");
				echo("</tr>");
				echo("</table>");
				echo("<input type='submit' value='Aggiorna tabella' class='btn'/>");
				echo("</form>");
			
		echo("</body>");
	echo("</html>");
?>