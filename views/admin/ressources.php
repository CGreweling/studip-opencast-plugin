<?
    if ($success = $flash['success']) {
        echo MessageBox::success($success);
    }
    if ($error = $flash['error']) {
        echo MessageBox::error($error);
    }
    if ($flash['question']) {
        echo $flash['question'];
    }


    $infobox_content = array(array(
        'kategorie' => _('Hinweise:'),
        'eintrag'   => array(array(
            'icon' => 'icons/16/black/info.png',
            'text' => _("Hier k�nnen Sie Ressourcen aus Stud.IP mit einem entprechenden Capture Agent verkn�pfen.")
        ))
    ));
    $infobox = array('picture' => 'infobox/administration.jpg', 'content' => $infobox_content);
?>
<script language="JavaScript">
OC.initAdmin();
</script>
<h3><?=_("Ressourcenzuweisung")?></h3>
