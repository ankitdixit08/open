<?
include("comps/config.php");
$c=filt($_GET['c']);
$c=$c=="" ? "http://open.subinsb.com/home":$c;
if(isset($_POST['submit'])){
 $u=filt($_POST['user']);
 $pa=filt($_POST['pass']);
 $sql=$db->prepare("SELECT * FROM users WHERE username=?");
 $sql->execute(array($u));
 while($r=$sql->fetch()){
  $p=$r['password'];
  $p_salt=$r['psalt'];
  $id=$r['id'];
 }
 $site_salt=")%*@*%!&%^)#@-_+`=~";
 $salted_hash = hash('sha256',$pa.$site_salt.$p_salt);
 if($p==$salted_hash){
  $tme=time()*60+1200;
  setcookie("curuser", $id, $tme, "/", $_SERVER['HTTP_HOST']);
  setcookie("wervsi", encrypter($id), $tme, "/", $_SERVER['HTTP_HOST']);
  header("Location:$c");
 }else{
  $er='Username/Password is Incorrect.';
 }
}
if($_GET['logout']==true){
 $tme=time()-301014600;
 setcookie("curuser", "", $tme, "/", $_SERVER['HTTP_HOST']);
 setcookie("wervsi", "", $tme, "/", $_SERVER['HTTP_HOST']);
 header("Location://open.subinsb.com");
}elseif($lg){header("Location: $c");}
?>
<!DOCTYPE html>
<html><head>
 <?$t="Sign In";include("comps/head.php");?>
</head><body>
 <?include("comps/header.php");?>
 <div class="content" style="text-align:center;">
  <div style="display:inline-block;width:200px;text-align:left;height:260px;padding:10px 20px 20px;">
   <h1>Social Sign In</h1>
   <a href="http://open.subinsb.com/oauth/login_with_facebook?c=<?echo$c;?>"><img src="http://open.subinsb.com/img/fb_login.png"/></a><cl/>
   <a href="http://open.subinsb.com/oauth/login_with_google?c=<?echo$c;?>"><img src="http://open.subinsb.com/img/google_login.png"/></a>
  </div>
  <div style="display:inline-block;vertical-align:top;width:200px;padding:10px 20px 20px;height:260px;text-align:left;">
   <h1>Sign In</h1>
   <form action="login?c=<?echo$c;?>" method="POST">
    E-Mail<br/>
    <input name="user" type="text" size="20"/><br/>
    Password<br/>
    <input name="pass" autocomplete="off" type="password" size="20"/><br/><cl/>
    <input name="submit" type="submit" value="Sign In"/><cl/>
    <?
    if(isset($er)){
     ser($er,"");
    }
    ?>
    <a href="http://open.subinsb.com/register"><button type="button" class="b-green">Sign Up</button></a><cl/>
    <a href="http://open.subinsb.com/me/ResetPassword"><button type="button" class="b-red">Forgot Password ?</button></a>
   </form>
  </div>
 </div>
</body></html>
