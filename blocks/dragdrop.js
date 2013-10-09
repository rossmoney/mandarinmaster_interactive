$(function() {
    $( ".dragdrop" ).draggable();
    $( ".dropslot" ).droppable({
      drop: function( event, ui ) {
      	var found = false;
      	if($(this).attr('word') == ui.draggable.attr('word'))
      	{
      		found = true;
      	}
      	if(found)
      	{
      		$( this ).css('background-color', 'green');
      		ui.draggable.css('background-color', 'green');
      		$( this ).html(ui.draggable.html());
      		ui.draggable.hide();
      		var correct = 0;
      		for(i = 0; i < ui.draggable.attr('count'); i++)
      		{
      			if($('#' + ui.draggable.attr('sBlock') + '_' + i + 'dragdrop').css('background-color') == 'rgb(0, 128, 0)')
      			{
      				correct++;
      			}
      		}
      		if(correct == ui.draggable.attr('count'))
      		{
      			if((attempts + 1) < ui.draggable.attr('count')) allocateActivityPoints(1, ui.draggable.attr('count'), attempts);
                        alert('You got them all correct!');
                        inProgress = false;
                        nextLevel();
      		}
      	} else {
                  if(attempts < ui.draggable.attr('count')) attempts++;
            }
      }
    });
 });