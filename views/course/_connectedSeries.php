<? use Studip\Button, Studip\LinkButton; ?>

<div id="admin-accordion">
        <p><?= _('W�hlen Sie eine Series aus, die Sie mit der aktuellen Veranstaltung verkn�pfen m�chten') ?>:</p>



    <? if (false && sizeof($connectedSeries) == 0) : ?>
        <div>
        <?= MessageBox::info(_("Es sind bislang noch keine Series verf�gbar. Bitte �berpr�fen Sie die globalen Opencast Matterhorn Einstellungen.")) ?>
        </div>
    <? else : ?>
        <div>
            <form action="<?= PluginEngine::getLink('opencast/course/edit/' . $course_id) ?>"
              method=post id="select-series" data-unconnected="<?= (empty($connectedSeries) ? 1 : 'false');?>">
                <div style="text-align: center;">
                    <? if (!empty($unconnectedSeries)) : ?>
                        <select class="series_select" multiple="multiple" name="series[]">

                            <? foreach ($unconnectedSeries as $serie) : ?>
                                <? if (isset($serie['identifier'])) : ?>

                                    <option value="<?= $serie['identifier'] ?>">
                                        <?= $serie['title'] ?>
                                        <? //= $series->additionalMetadata?>
                                    </option>
                                <? endif ?>
                            <? endforeach ?>
                        </select>
                    <? endif ?>
                </div>
                <div style="padding-top:2em;clear:both" class="form_submit">
                    <?= Button::createAccept(_('�bernehmen'), array('title' => _("�nderungen �bernehmen"))); ?>
                    <?= LinkButton::createCancel(_('Abbrechen'), PluginEngine::getLink('opencast/course/index')); ?>
                </div>
            </form>
        </div>
    <? endif; ?>
    <p><?= _("Zugeordnete Series") ?></p>
    <div>
        <ul style="list-style-type: none;margin:0;padding-left:50px">
            <? if (!empty($connectedSeries)) : ?>
                <? foreach ($connectedSeries as $serie) : ?>
                    <li>
                        <?= $serie['title'] ?>
                        <a href="<?= PluginEngine::getLink('opencast/course/remove_series/' . $course_id . '/' . $serie['identifier']) ?>">
                            <?= Assets::img('icons/16/blue/trash.png', array('title' => _('Zuordnung l�schen'), 'alt' => _('Zuordnung l�schen'))) ?>
                        </a>
                    </li>
                <? endforeach ?>
            <? else : ?>
                <li style="padding-top:5px">
                    <p><?= _("Bislang wurde noch keine Series zugeordnet.") ?></p>
                </li>
            <? endif ?>
        </ul>
    </div>
</div>