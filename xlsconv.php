<script type="text/javascript" charset="utf-8">
function selText() {
    document.getElementById("txt1").select();
}

function greater_smaller(r=0){
    if (r==0) {
        var t = document.getElementById("txt1").value;
        t = t.replace(/([ |\d|\n]<[ |\d])/ig,"&lt;");
        t = t.replace(/([ |\d]>[ |\d])/ig,"&gt;");
        document.getElementById("txt1").value = t;
    } else {
        var t = document.getElementById("txt1").value;
        t = t.replace(/(&lt;)/g,"<");
        t = t.replace(/(&gt;)/g,">");
        document.getElementById("txt1").value = t;
    }
}


function strip_tags(){
    var t = document.getElementById("txt1").value;
    document.getElementById("txt1").value = t.replace(/(<([^>]+)>)/ig,"");
}

function remove_comment () {
    var t = document.getElementById("txt1").value;
    document.getElementById("txt1").value = t.replace(/(\n> )/g,"\n");
}


function remove_dot () {
    var t = document.getElementById("txt1").value;
    document.getElementById("txt1").value = t.replace(/(\n•)/g,"  *");
}

function all_conv(){
    greater_smaller();
    strip_tags();
    greater_smaller(1);
    remove_comment();
    remove_dot();
    
    selText();
}
</script>

<style type="text/css">
.xlsconv__form {
	border: 1px solid #ccc;
	padding: 1em;
}

#txt1 {
    width:100%;
    font-family:courier;
}
</style>

<?php
$s = $_POST['s'];
$fromto = $_POST['fromto'];

if ($fromto=="E2W"){
	$s = str_replace("\r\n", " |\n| ", $s);
	$s = str_replace("\t", " | ", $s);
	//$s = str_replace("|  |", "| . |", $s);
	$s = "| ".$s;
	$s = substr($s,0,-2); //get rid of last newline conversion
 
    //explode the source by line
    $arrayS = preg_split ("/[\n]+/", $s); # Change from $arrayS = preg_split ("/[\n,]+/", $s);
    $nb_lines = count ($arrayS)-1;
    $s = $s . $nb_lines;
    $s = "";
    foreach ( $arrayS as $key => $lines ){
        if ($key == 0) {
            $lines = str_replace("|", "^", $lines);			
        }//end if
        
        $s = $s . $lines .  "\n";
    }//end for
 
    $s = substr($s,0,-2); //get rid of last newline conversion
} else {
	$s = str_replace("^", "|", $s);
	$s = str_replace("|\r\n|", "\r\n", $s);
	$s = str_replace("\r\n ", "\r\n", $s);
	$s = str_replace(" |", "|", $s);
	$s = str_replace("| ", "|", $s);
	$s = str_replace("|", "\t", $s);
	$s = substr($s,1); // get rid of first | without /r/n
 
}
?>

<div onenter="selText()">
    <h1>WIKI2EXCEL converter</h1>
 
    Copy and paste your Excel or Wiki table below and press [Convert!]<br/>

    <form class="xlsconv__form" method=POST action="">
        <br>
        <input type="radio" name="fromto" value="E2W" checked>Excel - Wiki<br>
        <input type="radio" name="fromto" value="W2E">Wiki - Excel<br><br>
        <INPUT TYPE=SUBMIT VALUE="Convert!"><br/><br>
        <input type="button" onclick="greater_smaller();" value="Try convert > and <">
        <input type="button" onclick="strip_tags();" value="Strip tags">
        <input type="button" onclick="remove_comment();" value="Remove comment">
        <input type="button" onclick="remove_dot();" value="Remove dot">
        <input style="background:lightgreen" type="button" onclick="all_conv();" value="Perform all actions">
        <textarea style="margin-top:5px" id="txt1" name="s" wrap="off"  rows=50 ><?=$s ?></textarea> 
    </form>

    <span style="font-size:80%">
        <strong>Version 0.1 : </strong>
        <ul>
            <li>Headers from wiki2excel will not be converted properly</li>
            <li>Links with alternative text (like <i>[[link|alt.text]]</i> ) will not convert properly</li>
        </ul>
    </span>

</div>