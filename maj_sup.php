
<?php

require_once '/data/fonc/ServerPing.php';

function test_ping($input,$nom)
{
    $serverPing=new ServerPing();
    $serverPing->send("$input", 1);
        if ($serverPing->isAlive()) {
                $sql = 'UPDATE supervision SET r_ping = "2" WHERE nom = "'.$nom.'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        } else {
                $sql = 'UPDATE supervision SET r_ping = "1" WHERE nom = "'.$nom.'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        }
}
function test_url($url,$nom)
{
        $headers = @get_headers($url);
        if(strpos($headers[0],'404') === false)
        {
                $sql = 'UPDATE supervision SET r_url = 2 WHERE nom = "'.$nom.'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        } else {
                $sql = 'UPDATE supervision SET r_url = 1 WHERE nom = "'.$nom.'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        }
}

function test_ssh($poil,$nom,$precedent)
{
        $SSH = @fsockopen($poil, 22, $errno, $errstr, 1);
        if ($SSH)
                {
                $sql = 'UPDATE supervision SET r_ssh = "2" WHERE nom = "'.$nom.'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                }else {
                $sql = 'UPDATE supervision SET r_ssh = "1" WHERE ip = "'.$nom.'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

                }
 }

$db = mysql_connect('<IP>', '<USER>', '<PASSWORD>');
mysql_select_db('blog',$db);

$sql2 = 'SELECT DISTINCT id,nom,ip,url,t_ping,t_ssh,t_url,r_ssh,r_ping,r_url FROM supervision ORDER BY ip';
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

while($data = mysql_fetch_assoc($req2))
    {

if ($data['t_ping'] == 1) {
test_ping($data['ip'],$data['nom']);
} else {
                $sql = 'UPDATE supervision SET r_ping = "0" WHERE nom = "'.$data['nom'].'"';
				$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
}

if ($data['t_url'] == 1) {
test_url($data['url'],$data['nom']);
} else {
                $sql = 'UPDATE supervision SET r_url = "0" WHERE nom = "'.$data['nom'].'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
}


if ($data['t_ssh']== 1)
{
test_ssh($data['ip'],$data['nom'],$data['r_ssh']);
} else {
                $sql = 'UPDATE supervision SET r_ssh = "0" WHERE ip = "'.$data['nom'].'"';
                                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
}

}
mysql_close();
?>
