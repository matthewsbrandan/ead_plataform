<script>
  function sendMessage(event){
    event.preventDefault();

    console.log(event);

    let data = {
      content: $('#text-question').val()
    };

    if(selectedLesson) data = {
      ...data,
      lesson_id: selectedLesson.id
    };

    $.post('{{ route('chat.store') }}',data).done(function(data){
      console.log(data);
    })
  }
</script>