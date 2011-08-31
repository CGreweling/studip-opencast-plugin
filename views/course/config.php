<? if (isset($message)): ?>
  <?= MessageBox::success($message) ?>
<? endif ?>

<?
$infobox_content = array(array(
    'kategorie' => _('Hinweise:'),
    'eintrag'   => array(array(
        'icon' => 'icons/16/black/info.png',
        'text' => _("Hier k�nnen die eingebundenen Vorlesungsaufzeichnungen aus dem angebundenen Opencast Matterhorn System verwaltet werden. Sie k�nnen Series, die noch keiner Veranstaltung zugeordnet sind der aktuellen Verantstaltung zuordnen. Wenn Sie bestehende Zuordnungen l�schen m�chten, klichen Sie auf den jeweiligen M�lleimer.")
    ))
));

$infobox = array('picture' => 'infobox/administration.jpg', 'content' => $infobox_content);
?>
<script language="JavaScript">
OC.initAdmin();
</script>
<h3><?=_('Verwaltung der eingebundenen Vorlesungsaufzeichnungen')?></h3>

<? if (empty($this->cseries)) : ?>
    <?= MessageBox::info(_("Sie haben noch keine Series aus Opencast mit dieser Veranstaltung verkn�pft. 
                            Bitte erstellen Sie zuerst eine Series oder verkn�pfen eine bereits vorhandene Series.")) ?>
    <div id="admin-accordion">
        <h3><?= _("Neue Series Anlegen") ?></h3>
        <?= $this->render_partial("course/_createSeries") ?>
        <h3><?=_('W�hlen Sie rechts eine Series aus, die Sie mit der aktuellen Veranstaltung verkn�pfen m�chten')?>:</h3>
        <?= $this->render_partial("course/_connectedSeries", array('course_id' => $course_id, 'cseries' => $cseries, 'rseries' => $rseries, 'series_client' => $series_client)) ?>
    </div>


<? elseif(!$connected) : ?>


   
    <div class="oc_schedule">
<!--    <h3><?=_('Veranstaltungsaufzeichnungen Planen')?>:</h3>
        <h4>Ablaufplan</h4>
        <p>Erst feststellen ob ein Raum mit CA da ist und dann den Ablaufplan posten mit Checkboxes zum Schedulen...</p> -->
        <table class="default">
            <tr>
                <th>Termin</th>
                <th>Titel</th>
                <th>Aktionen</th>
            </tr>
            
            <? foreach($dates as $d) : ?>
                <tr>
                <? $date = new SingleDate($d['termin_id']); ?>
                <td> <?=$date->getDatesHTML()?> </td>
                <? $issues = $date->getIssueIDs(); ?>
                <? if(is_array($issues)) : ?>
                    <? foreach($issues as $is) : ?>
                        <? $issue = new Issue(array('issue_id' => $is));?>
                        <? $topic = true; ?>
                        <td> <?= my_substr($issue->getTitle(), 0 ,80 ); ?></td>
                    <? endforeach; ?>
                <? else: ?>
                        <? $topic = false; ?>
                        <td> <?=_("Kein Titel eingetragen")?></td>
                <? endif; ?>
                <td>
                    <? $resource = $date->getResourceID(); ?>
                    <? if(isset($resource) && OCModel::checkResource($resource)) :?>
                        <? if(OCModel::checkScheduled($course_id, $resource, $date->termin_id)) :?>
                            <a href="<?=PluginEngine::getLink('opencast/course/unschedule/'.$resource .'/'. $date->termin_id ) ?>">
                                <?= Assets::img('icons/16/blue/video.png', array('title' => _("Aufzeichnung ist bereits geplant. Klicken Sie hier um die Planung zu aufzuheben"))) ?>
                            </a>
                        <?  else : ?>
                            <? if($topic) :?>
                            <a href="<?=PluginEngine::getLink('opencast/course/schedule/'.$resource .'/'. $date->termin_id ) ?>">
                                <?= Assets::img('icons/16/blue/date.png', array('title' => _("Aufzeichnung planen"))) ?>
                            </a>
                            <? else :?>
                                <?= Assets::img('icons/16/blue/exclaim-circle.png', array('title' =>  _("Bitte geben Sie ein Thema f�r diese Veranstaltung an."))) ?>
                            <? endif ;?>
                        <? endif; ?>
                    <?
                        
                    ?>
                        <?// $date->getRoom() ?>
                    <? elseif(false) : ?>
                        <?= Assets::img('icons/16/blue/video.png') ?>
                    <?
                        /*  Wenn es eine Aufzeichnung gibt, optionen zum Unsichtbar machen anbieten
                         *  Wenn keine Aufzeichnung aus OC gibt dann ersma nix machen
                         *
                         *
                         */
                    ?>
                    <? else : ?>
                        <?= Assets::img('icons/16/red/exclaim-circle.png', array('title' =>  _("Es wurde bislang kein Raum gebucht"))) ?>
                    <? endif; ?>


                </td>
                </tr>
            <? endforeach; ?>

        </table>
    </div>

<? else: ?>
   <table class="default">
            <tr>
                <th>Titel</th>
                <th>Status</th>
                <th>Aktionen</th>
            </tr>
            <?foreach($episodes as $episode) :?>

                <? if(isset($episode->mediapackage)) :?>
                <tr>
                    <td>
                        <?=$episode->mediapackage->title ?>
                    </td>
                    <td>
                        <?$visible = OCModel::getVisibilityForEpisode($course_id, $episode->mediapackage->id); ?>
                        <? if($visible['visible'] == 'true') : ?>
                            <?=_("Sichtbar")?>
                        <? else : ?>
                            <?=_("Unsichtbar")?>
                        <? endif; ?>
                    </td>
                    
                    <td>
                        <a href="<?=PluginEngine::getLink('opencast/course/toggle_visibility/'.$episode->mediapackage->id ) ?>">
                            <?= Assets::img('icons/16/blue/visibility-visible.png', array('title' => _("Aufzeichnung unsichtbar schalten"))) ?>
                        </a>
                    </td>
                </tr>
                <? endif ;?>
            <? endforeach; ?>

   </table>
<? endif; ?>
