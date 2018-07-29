IMPORTANT
1. crudcon.php should be placed outside your directory ../crudcon.php
2. Create a database first with the name "gencrud_database" before executing the sql.
3. Adding data is so easy
	$add = data_cloaker('encrypt','NAME_OF_TABLE*NUMBER_OF_COLUMN*1|LABEL_1/2|LABEL_2');
        $add = "gen_add.php?ref=".$add; 
4. Editing data
	$edit = data_cloaker('encrypt','fac_children*child_id*'.$id.'*2|First Name/3|Middle Name/4|Last Name/5|Gender/6|Birthday/7|Remarks');
        $edit = "edit.php?ref=".$edit; 
5. Deleting data
	$delete = data_cloaker('encrypt','fac_children*child_id*'.$id.'*2|First Name/3|Middle Name/4|Last Name/5|Gender/6|Birthday/7|Remarks');
        $delete = "delete.php?ref=".$delete; 