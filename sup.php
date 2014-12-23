<?php
function resultat($test)
{
if ($test=="1"){ echo '<img src="./img/rouge.png" alt="KO">'; }
if ($test=="2"){ echo '<img src="./img/vert.png" alt="OK">'; }
if ($test=="0"){ echo '<img src="./img/gris.png" alt="NA">'; }

}
$db = mysql_connect('<IP_BASE>', '<USER>', '<MDP_BDD>');
mysql_select_db('blog',$db);
$sql = 'SELECT DISTINCT id,nom,ip,url,t_ping,t_ssh,t_url,r_ping,r_ssh,r_url FROM supervision ORDER BY ip';
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
echo '<div style="background:url(./img/fond_div.png);margin:30px;padding:30px;">';
while($data = mysql_fetch_assoc($req))
    {
echo '<div style="background:url(./img/fond_div.png);margin:20px;padding:30px;width:200px;position: relative;display:inline-block;">';
echo $data['nom'].'<br>';
resultat($data['r_ping']);
echo "Resultat du ping<br>";
resultat($data['r_ssh']);
echo "Resultat du SSH<br>";
resultat($data['r_url']);
echo "Resultat URL<br>";
echo "</div>";
}
mysql_close();
echo '</div>';
?>
