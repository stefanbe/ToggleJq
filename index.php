<?php if(!defined('IS_CMS')) die();

class ToggleJq extends Plugin {

    function getContent($value) {
        $out = "...Weiter";
        if($this->settings->get("toggle_out"))
            $out = str_replace('"','\"',$this->settings->get("toggle_out"));
        $in = "...Zurück";
        if($this->settings->get("toggle_in"))
            $in = str_replace('"','\"',$this->settings->get("toggle_in"));
$tmp = explode("###",$value);
if(count($tmp) == 3) {
    $out = $tmp[0];
    $in = $tmp[1];
    $value = $tmp[2];
}
        $img = "false";
        if($this->settings->get("toggle_img") == "true") {
            $img = "true";
            $out = $this->PLUGIN_SELF_URL.'out.png';
            $in = $this->PLUGIN_SELF_URL.'in.png';
        }
        $toggle_speed = 600;
        if($this->settings->get("toggle_speed") >= "0" and is_numeric($this->settings->get("toggle_speed")))
            $toggle_speed = $this->settings->get("toggle_speed");

        # JavaSript nur einmal einbinden
        global $syntax;
        $toggle_script = '<script type="text/javascript">'
            .'var toggle_img = '.$img.';'
            .'var toggle_out = "'.$out.'";'
            .'var toggle_in = "'.$in.'";'
            .'var toggle_speed = '.$toggle_speed.';'
            .'</script>'
            .'<script type="text/javascript" src="'.$this->PLUGIN_SELF_URL.'toggle_jquery.js"></script>';
        $syntax->insert_jquery_in_head('jquery');
        $syntax->insert_in_head($toggle_script);
        # da die Syntax.php bei Blockelementen <br> entfernt machen wir welche dazu
        # da wir das als Inline Element nutzen.
        return '<div class="toggle-content" style="display:inline;">-html_br~'.$value.'</div>-html_br~';
    }

    function getConfig() {
        global $ADMIN_CONF;
        $language = $ADMIN_CONF->get("language");
        // Das mu� auf jeden Fall geschehen!
        $config['deDE'] = array();
        $config['deDE']['toggle_out']  = array(
            "type" => "text",
            "description" => "Text für Ausklappen z.B. ...Weiter",
            "maxlength" => "100",
            "size" => "30",
            );
        $config['deDE']['toggle_in']  = array(
            "type" => "text",
            "description" => "Text für Einklappen z.B. ...Zurück",
            "maxlength" => "100",
            "size" => "30",
            );
        $config['deDE']['toggle_speed']  = array(
            "type" => "text",
            "description" => "Animations Geschwindigkeit in Millisekunden",
            "maxlength" => "5",
            "size" => "5",
            );
        $config['deDE']['toggle_img'] = array(
            "type" => "checkbox",
            "description" => "oder Bilder benutzen"
            );

        if(isset($config[$language])) {
            return $config[$language];
        } else {
            return $config['deDE'];
        }
    }

    function getInfo() {
        global $ADMIN_CONF;
        $language = $ADMIN_CONF->get("language");

        $info['deDE'] = array(
            // Plugin-Name
            "<b>ToggleJq</b> Revision: 139",
            // Plugin-Version
            "2.0",
            // Kurzbeschreibung
            'Mit diesem Plugin kann Content Inhalt ein und aus geblendet werden<br /><SPAN style="color:red;">Benötigt JavaSript</SPAN><br />Platzhalter:<br /><SPAN style="font-weight:bold;">{ToggleJq|Content Inhalt}</SPAN><br /><br />Die Bilder für das Ein/Ausklappen (in.pnp und out.png) liegen im Pluginordner und können da Getauscht werden.',
            // Name des Autors
            "stefanbe",
            // Download-URL
            "http://www.mozilo.de/forum/index.php?action=media",
            array('{ToggleJq|}' => 'Content Inhalt')
            );

        if(isset($info[$language])) {
            return $info[$language];
        } else {
            return $info['deDE'];
        }
    }
}

?>