#!/usr/local/bin/ruby
#
class Moo_game
   attr_writer :keta #正解の数 rubyはセッターゲッターが不要？個の例は書き込みのみ許可
   attr_writer :answer,:question  #正解とクエスチョン
   attr_reader :hit,:blow #Hit数,Blow数 
  #正解を算出
  def make_answer
     ans = []
     ret = ""
    while ans.size < @keta
      ans << rand(9)
      ans.uniq!
    end
    ans.each{|s| ret<<s.to_s}
  return ret
  end 
  #評価関数
  def chk_answer
   @hit = 0
   @blow = 0
   @keta.times{|i|  
     @keta.times{|j|
       chk=@question[i,1]  #入力数からi桁目を取り出す
       chk1=@answer[j,1]  #正解数からj桁目を取り出す
     if (chk==chk1) then  #もし、取り出した数字が等しければ
        if (i==j) then #もし、取り出した位置（桁）が同じならば
          @hit +=1  #ヒットの数に１足す
        else
          @blow +=1 #ブローの数に１足す
        end
     end
      }
    }
  end
end
#
require "cgi"
require 'cgi/session'
#debug
#ARGV.replace(["answer=001&submit=OK"])
#
input = CGI.new
session = CGI::Session.new(input)
#header出力
#これで出力しないとセッション変数が保存されない
puts input.header("type" => "text/html", "charset" => "utf-8")
#
moo_game = Moo_game.new
#初期値設定
keta = 3
hit = 0
blow = 0
flag = 0
msg = "がんばろう"
moo_game.keta = keta #桁数設定
#
print <<EOF
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
MooGameForRuby
</title>
</head>
<body>
<table border=1 width=760>
<tr><td width=350>
<P>MooゲームVer1.0<BR>
Copyright（C）Akia345<BR>
数値を入力してね<BR>
EOF
#セッション情報取得
answer = session['answer']
if (answer == nil) then
  #正解設定
  answer = moo_game.make_answer
  session['answer'] = answer
  session['count'] = 0
end 
#ＧＯ！ボタン処理session['count']
if (input['submit']!="") then
  #入力チェック
  question=CGI.escapeHTML(input['answer']) #解答を代入
  question.to_i #整数に変換
  if (question.length <=0 or question.length >keta) then
    print "<font color=red>入力された数字の桁数が違うか未入力です！！</font><br>"
  else
    #答え合わせ
    moo_game.question = question
    moo_game.answer = answer
    moo_game.chk_answer
    hit = moo_game.hit
    blow = moo_game.blow
    #試行回数カウント＆表示
    #セッション変数は直接計算ができない？
    cnt = session['count'].to_i
    cnt +=1
    session['count'] = cnt
    #session['count'] +=1
    print "ただいまの試行回数＝#{session['count']}回です。<br>"  #試行回数を表示
    if (answer == question) then
        flag = 1
        msg = "正解！"
    end
  end
end
#終了処理
if (input['end']!="" or flag!=0) then #終了ボタンが押されたか正解したら
  session.delete  #セッションを削除
end
print <<EOF
<BR>
</P>
<form method="POST" action=test.rb>
<center>
<TABLE border="1">
    <TR>
      <TD><INPUT size="10" type="text" maxlength="9" name="answer"></TD>
      <TD><INPUT type="submit" name="submit" value="GO!"></TD>
    </TR>
    <TR>
      <TD>Hit数<br>#{hit}</TD>
      <TD>Blow数<br>#{blow}</TD>
    </TR>
    <TR>
      <TD colspan="2" valign="center">ただいまの桁数<BR>
      <center>#{keta}桁</center></TD>
    </TR>
</TABLE>
</center>
<br>
<input type="submit" name="end" value="終了"><br>
あなたの入力した数字＝#{question}<br>正解＝#{answer}<h3>#{msg}！</h3><br>
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
EOF
