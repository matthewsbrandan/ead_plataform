<script>
  let timeClearTextQuestion = null;
  function sendMessage(event){
    event.preventDefault();

    let data = { content: $('#text-question').val() };

    if(selectedLesson) data = {
      ...data,
      lesson_id: selectedLesson.id
    };

    if(timeClearTextQuestion) clearTimeout(timeClearTextQuestion);
    $('#text-question').removeClass('has-success has-error').next().html('').hide();
    $.post('{{ route('chat.store') }}',data).done(function(data){
      $('#text-question').addClass(data.result ? 'has-success' : 'has-error').next().html(
        data.result ? 'Mensagem enviada com sucesso':data.response
      ).show();

      if(data.result){
        $('#container-questions').prepend(handleAddMensage(data.response));
      }
    }).fail(() => {
      $('#text-question').addClass('has-error').next().html(
        'Houve um erro ao enviar a mensagem'
      ).show();
    }).always(() => {
      $('#text-question').val('').focus();
      timeClearTextQuestion = setTimeout(() => {
        $('#text-question').removeClass('has-success has-error').next().html('').hide();
      },3000)
    })
  }
  function loadLessonMessages(){
    if(!selectedLesson) return;
    
    let skip = $('#container-questions .content-message').length;
    $.get(`{{ substr(route('chat.lesson',['lesson_id' => 0, 'skip' => 0]),0,-3) }}${selectedLesson.id}/${skip}`).done(function(data){
      console.log(data);
      if(data.result) data.response.chats.forEach(message => {
        $('#container-questions').append(
          handleAddMensage(message)
        );
      });
    });
  }
  function handleAddMensage(message){
    return `
      <div class="content-message" id="message-${ message.id }">
        <div class="content-avatar">
          <img
            src="${ message.author_thumbnail }"
          />
        </div>
        <div class="message-info">
          <strong class="message-author">${ message.author_name }</strong>
          <time class="message-timestamp">
            ${ message.date_formatted }
          </time>
          <div class="message-body">
            ${ message.content }
          </div>
          <div class="message-responses" id="responses-message-${ message.breadcrumbs }"></div>
        </div>
      </div>
    `;
  }
</script>