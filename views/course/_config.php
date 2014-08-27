<? use Studip\Button, Studip\LinkButton; ?>
<? if (empty($this->connectedSeries)) : ?>
    <?= MessageBox::info(_("Sie haben noch keine Series aus Opencast mit dieser Veranstaltung verkn�pft.
                                Bitte erstellen Sie eine neue Series oder verkn�pfen eine bereits vorhandene Series."))?> 
    
    <div id="admin-accordion">
        <?= $this->render_partial("course/_createSeries", array()) ?>
        <?= $this->render_partial("course/_connectedSeries", array('course_id' => $course_id, 'connectedSeries' => $connectedSeries, 'unonnectedSeries' => $unonnectedSeries, 'series_client' => $series_client)) ?>
    </div>
<? else:?>
    <h2><?= _("Zugeordnete Series") ?></h2>
    <p><?= _("Sie k�nnen hier die Verkn�pfung aufheben. Klicken Sie hierf�r auf das entsprechende M�lltonnensymbol") ?></p>
    <div>
        <? if (!empty($connectedSeries)) : ?>
            <? foreach ($connectedSeries as $serie) : ?>
                    <?= utf8_decode($serie['title']) ?>
                    <a href="<?= PluginEngine::getLink('opencast/course/remove_series/' . $course_id . '/' . $serie['identifier']) ?>">
                        <?= Assets::img('icons/16/blue/trash.png', array('title' => _('Zuordnung l�schen'), 'alt' => _('Zuordnung l�schen'))) ?>
                    </a>
            <? endforeach ?>
        <? endif ?>
        <div style="padding-top:2em;clear:both" class="form_submit">
            <?= LinkButton::create(_('OK'), PluginEngine::getLink('opencast/course/index')); ?>
            <?= LinkButton::createCancel(_('Abbrechen'), PluginEngine::getLink('opencast/course/index')); ?>
        </div>
    </div>
<? endif; ?>






