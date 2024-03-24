<table class="table table-striped table-bordered table-hover example" id="timetable">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('no'); ?></th>
            <th><?php echo $this->lang->line('time'); ?></th>
            <th><?php echo $this->lang->line('time_type'); ?></th>
            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
        </tr>
    </thead>
    <tbody>

        <?php
        $count = 1;
        foreach ($timetables as $value) {
        ?>
            <tr>
                <td><?= $count; ?></td>
                <td class="mailbox-name"> <?php echo $value['time_from']." - ".$value['time_to'] ?></td>
                <td class="mailbox-name"> 
                    <?php
                        if($value['time_type'] == 0)
                            echo $this->lang->line('lesson')." ".$this->lang->line('time');
                        else
                            echo $this->lang->line('rest'). " " .$this->lang->line('time');
                    ?>
                </td>
                <td class="mailbox-date pull-right">
                    <?php
                    if ($this->rbac->hasPrivilege('compose_timetable', 'can_edit')) {
                    ?>
                        <div data-placement="left" onclick="edit(<?php echo $value['id']?>)"
                            class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                            <i class="fa fa-pencil"></i>
                    </div>
                    <?php
                    }
                    if ($this->rbac->hasPrivilege('compose_timetable', 'can_delete')) {
                    ?>
                        <div data-placement="left" onclick="delete(<?php echo $value['id']?>)" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>');">
                            <i class="fa fa-remove"></i>
                    </div>
                    <?php } ?>
                </td>
            </tr>
        <?php
        $count++;
        }
        ?>
    </tbody>
</table>