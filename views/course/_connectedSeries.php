<? use Studip\Button, Studip\LinkButton; ?>
    <p><?= _('Serie verkn�pfen') ?>:</p>
    <? if (false && sizeof($connectedSeries) == 0) : ?>
        <div>
        <?= MessageBox::info(_("Es sind bislang noch keine Series verf�gbar. Bitte �berpr�fen Sie die globalen Opencast Matterhorn Einstellungen.")) ?>
        </div>
    <? else : ?>
        <div>
            <span class="oc_config_infotext">
                <?=_('W�hlen Sie eine Series aus, die Sie mit der aktuellen Veranstaltung verkn�pfen m�chten.')?>
            </span>
            <form action="<?= PluginEngine::getLink('opencast/course/edit/' . $course_id) ?>"
              method=post id="select-series" data-unconnected="<?= (empty($connectedSeries) ? 1 : 'false');?>">
                <div style="text-align: center;">
                    <? if (!empty($unconnectedSeries)) : ?>
                        <select class="series_select" multiple="multiple" name="series[]">

                            <? foreach ($unconnectedSeries as $serie) : ?>
                                <? if (isset($serie['identifier'])) : ?>

                                    <option value="<?= $serie['identifier'] ?>">
                                        <?= utf8_decode($serie['title'])?>
                                        <? //= $series->additionalMetadata?>
                                    </option>
                                <? endif ?>
                            <? endforeach ?>
                        </select>
                    <? endif ?>
                </div>
                <div style="padding-top:2em;clear:both" class="form_submit change_series">
                    <?= Button::createAccept(_('�bernehmen'), array('title' => _("�nderungen �bernehmen"))); ?>
                    <?= LinkButton::createCancel(_('Abbrechen'), PluginEngine::getLink('opencast/course/index')); ?>
                </div>
            </form>
        </div>
    <? endif; ?>