<?php
session_start();//���å���������������
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
<P>Moo������Ver2.5<BR>
Copyright��C��Akira345<BR>
<?php
require("./function-moogame.php");//�����ؿ������
///���������ѿ������///
$keta=3;//����η��������
//$setvalue=123;//���������
$flag=0;//���򤫤ɤ����Υե饰
$hit=0;//�ҥåȤο�
$blow=0;//�֥��ο�

///�����������롼����ƤӽФ����������줿���������///
if ($_SESSION['backup']=="" and $setvalue=="")//�⤷�������Хå����åפ�����ä���
{
list($setvalue,$errorcode)=value_generate($keta);//�����������
$_SESSION['backup']=$setvalue;//���å������������Ͽ
}
elseif ($_SESSION['backup']!="")//���å������������äƤ�����
{
$setvalue=$_SESSION['backup'];//���å�����������ѿ�������
}

///��λ����///
if ($_POST['end']!="" or $flag!=0)//��λ�ܥ��󤬲����줿�����򤷤���
{
$_SESSION['backup']="";//���å�������
$setvalue="";//�������
$_SESSION['count']="";//��Բ������
}

///�ǣϡ��ܥ������///
if ($_POST['submit']!="" or $_POST['answer']!="")//�ܥ��󤬲����줿���������ϥե����ब����å����줿��
{
$input_value=$_POST['answer'];//����������
//������ץ�����ƤӽФ�
list($flag,$hit,$blow,$errorcode)=moogame($setvalue,$input_value);

	if ($errorcode!=0 and $errorcode!=1)
	{
	print ("<font color=red>���顼��ȯ�������顼�����ɡ�$errorcode</font>");
	}
}

///���ϥ��顼����///
if ($errorcode==1)//���Ϥ��줿���ͤη���ȵ���η�������פ��Ƥ��ʤ����
{
print ("<font color=red>���Ϥ��줿�����η�����㤦��̤���ϤǤ�����</font><br>");
}
else
{
print ("���ͤ����Ϥ��Ƥ�<BR>");
}

///��Բ��������ȡ�ɽ��///
if ($setvalue!="" and $_SESSION['count']=="")//���򤬵�Ͽ����Ƥ��Ƥ��Ļ�Բ����������Ȥ��줿���ʤ����
{
$_SESSION['count']=1;//��Բ���򥻥å�������Ͽ
$count=1;//��Բ��������
}
else
{
$count=$_SESSION['count'];//���å�������Ͽ����Ƥ����Բ�����ѿ�������
$count=$count+1;//������Ȥ����䤹
$_SESSION['count']=$count;//���å�������Ͽ
}

print ("�������ޤλ�Բ����".$count."��Ǥ���<br>");//��Բ����ɽ��

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
      <TD>Hit��<br><?php print ("$hit"); ?></TD>
      <TD>Blow��<br><?php print ("$blow"); ?></TD>
    </TR>
    <TR>
      <TD colspan="2" valign="center">�������ޤη��<BR>
      <center><?php print("$keta"); ?>��</center></TD>
    </TR>
</TABLE>
</center>

<br>
<input type="submit" name="end" value="��λ"><br>
<?php
///��å�����ɽ��///
print ("���ʤ������Ϥ���������$input_value<br>�����$setvalue");
if ($flag!=0)
{
print ("<h3>����</h3><br>\n");
}
else
{
print ("<h3>����Ф���</h3><br>\n");
}

?>
</form>
</td>
<td>
<!--����-->
<br>
�ҥåȿ��Ȥϡ����������ҥåȿ��Ȥϡ�����η�ʰ��֡ˤȿ���Ʊ���Ŀ���ɽ���ޤ���<br>
�㤨�С����򤬣������Ǥ��ꡢ���ʤ������줿�ͤ����������ä���硢����Ʊ�����Ǥ���Ʊ������Ǥ���<br>
�Ǥ����顢�ҥåȿ��ϣ��Ȥʤ�ޤ���<br>
�Ĥޤꡢ����ξ��ϥҥåȿ��ϣ��ˤʤ�Ȥ����櫓�Ǥ��͡�������Υ롼��Ǥ�������ҥåȿ��ϸ���ʤ��餷����
<br>
<br>
�֥����Ȥϡ����������֥����Ȥϡ�����η�ʰ��֡ˤ�<b>�㤦</b>��������ʳ��η�ʰ��֡ˤˤ��ο��������äƤ��뤽�ο����θĿ���ɽ���ޤ���<br>
�㤨�С���ۤɤ�Ʊ���褦�����򤬣������Ǥ��ꡢ���ʤ������줿�ͤ����������ä���硢���Ϸ�ʰ��֡ˤ��������ޤ�������˴ޤޤ�Ƥ��ޤ���<br>
�Ǥ����顢�֥����ϣ��Ȥʤ�ޤ���<br>
��äơ����ξ��ϣ��ҥåȣ��֥��Ȥʤ�ޤ���<br>
�ʲ��ˤ����Ĥ����Ф��Ƥ����ޤ��ΤǤ褯ʬ����ʤ��ͤ�ľ��Ū�����򤷤Ʋ�������<br>
<br>
<br>
<table border=1>
<tr>
<td><center>����</center></td><td><center>������</center></td><td><center>Ƚ��</center></td>
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
