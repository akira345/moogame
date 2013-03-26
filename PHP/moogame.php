<?php
session_start();//セッション管理使用宣誓
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title>
MooGameForPHP4
</title>
</head>
<body>
<table border=1 width=760>
<tr><td width=350>
<P>MooゲームVer2.5<BR>
Copyright（C）Akira345<BR>
<?php
require("./function-moogame.php");//外部関数をロード
///初期設定＆変数初期化///
$keta=3;//正解の桁数を設定
//$setvalue=123;//正解を設定
$flag=0;//正解かどうかのフラグ
$hit=0;//ヒットの数
$blow=0;//ブローの数

///ランダム生成ルーチン呼び出しと生成された正解の設定///
if ($_SESSION['backup']=="" and $setvalue=="")//もし、正解もバックアップも空だったら
{
list($setvalue,$errorcode)=value_generate($keta);//ランダムに生成
$_SESSION['backup']=$setvalue;//セッションに正解を登録
}
elseif ($_SESSION['backup']!="")//セッションに正解が入っていたら
{
$setvalue=$_SESSION['backup'];//セッションの正解を変数に代入
}

///終了処理///
if ($_POST['end']!="" or $flag!=0)//終了ボタンが押されたか正解したら
{
$_SESSION['backup']="";//セッションを削除
$setvalue="";//正解を削除
$_SESSION['count']="";//試行回数を削除
}

///ＧＯ！ボタン処理///
if ($_POST['submit']!="" or $_POST['answer']!="")//ボタンが押されたか数値入力フォームがクリックされたら
{
$input_value=$_POST['answer'];//解答を代入
//ゲームプログラムを呼び出す
list($flag,$hit,$blow,$errorcode)=moogame($setvalue,$input_value);

	if ($errorcode!=0 and $errorcode!=1)
	{
	print ("<font color=red>エラーが発生！エラーコード＝$errorcode</font>");
	}
}

///入力エラー処理///
if ($errorcode==1)//入力された数値の桁数と規定の桁数が一致していなければ
{
print ("<font color=red>入力された数字の桁数が違うか未入力です！！</font><br>");
}
else
{
print ("数値を入力してね<BR>");
}

///試行回数カウント＆表示///
if ($setvalue!="" and $_SESSION['count']=="")//正解が記録されていてかつ試行回数がカウントされたいなければ
{
$_SESSION['count']=1;//試行回数をセッションに登録
$count=1;//試行回数を設定
}
else
{
$count=$_SESSION['count'];//セッションに登録されている試行回数を変数へ代入
$count=$count+1;//カウントを１増やす
$_SESSION['count']=$count;//セッションに登録
}

print ("ただいまの試行回数＝".$count."回です。<br>");//試行回数を表示

?>

<BR>
</P>

<form method="POST" action=moogame.php>
<center>
<TABLE border="1">
    <TR>
      <TD><INPUT size="10" type="text" maxlength="9" name="answer"></TD>
      <TD><INPUT type="submit" name="submit" value="GO!"></TD>
    </TR>
    <TR>
      <TD>Hit数<br><?php print ("$hit"); ?></TD>
      <TD>Blow数<br><?php print ("$blow"); ?></TD>
    </TR>
    <TR>
      <TD colspan="2" valign="center">ただいまの桁数<BR>
      <center><?php print("$keta"); ?>桁</center></TD>
    </TR>
</TABLE>
</center>

<br>
<input type="submit" name="end" value="終了"><br>
<?php
///メッセージ表示///
print ("あなたの入力した数字＝$input_value<br>正解＝$setvalue");
if ($flag!=0)
{
print ("<h3>正解！</h3><br>\n");
}
else
{
print ("<h3>がんばろう！</h3><br>\n");
}

?>
</form>
</td>
<td>
<!--解説-->
<br>
ヒット数とは？・・・・ヒット数とは、正解の桁（位置）と数が同じ個数を表します。<br>
例えば、正解が１７５であり、あなたが入れた値が９７１だった場合、７が同じ数でかつ同じ桁数です。<br>
ですから、ヒット数は１となります。<br>
つまり、正解の場合はヒット数は３になるというわけですね。（本来のルールでは正解時ヒット数は言わないらしい）
<br>
<br>
ブロー数とは？・・・・ブロー数とは、正解の桁（位置）が<b>違う</b>が、それ以外の桁（位置）にその数字が入っているその数字の個数を表します。<br>
例えば、先ほどと同じように正解が１７５であり、あなたが入れた値が９７１だった場合、１は桁（位置）がちがいますが正解に含まれています。<br>
ですから、ブロー数は１となります。<br>
よって、この場合は１ヒット１ブローとなります。<br>
以下にいくつか例を出しておきますのでよく分からない人は直感的に理解して下さい。<br>
<br>
<br>
<table border=1>
<tr>
<td><center>正解</center></td><td><center>入力値</center></td><td><center>判定</center></td>
</tr>
<tr>
<td><center>123</center></td><td><center>524</center></td><td><center>1H0B</center></td>
</tr>
<tr>
<td><center>123</center></td><td><center>341</center></td><td><center>0H2B</center></td>
</tr>
<tr>
<td><center>847</center></td><td><center>123</center></td><td><center>0H0B</center></td>
</tr>
<tr>
<td><center>834</center></td><td><center>263</center></td><td><center>0H1B</center></td>
</tr>
</table>
</td></tr>
</table>
</BODY>
</HTML>
