<script>
  let timeClearTextQuestion = null;
  function sendMessage(event){
    event.preventDefault();

    let data = { content: $('#text-question').val() };

    if(isChatTeacher) data = {
      ...data,
      course_id: {{ $course->id }},
      user_id: {{ $user_id ?? auth()->user()->id }}
    };
    else data = {
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
        if(isChatTeacher) $('#container-questions').append(handleAddMensage(data.response));
        else $('#container-questions').prepend(handleAddMensage(data.response));
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
      if(data.result) data.response.chats.forEach(message => {
        $('#container-questions').append(
          handleAddMensage(message)
        );
      });
    });
  }
  function loadTeacherMessages(){
    let skip = $('#container-questions .content-message').length;
    $.get(`{{ substr(route('chat.course',['slug' => $course->slug, 'user_id' => $user_id ?? auth()->user()->id, 'skip' => 0]),0,-1) }}${skip}`).done(function(data){
      if(data.result) data.response.chats.forEach(message => {
        $('#container-questions').prepend(
          handleAddMensage(message)
        );
      });
    });
  }
  function handleAddMensage(message){
    let isMe = false;

    if(isChatTeacher){
      isMe = (message.is_course && message.user_id !== {{ auth()->user()->id }}) ||
             (!message.is_course && message.user_id === {{ auth()->user()->id }});
    }
    
    return `
      <div class="content-message ${isMe ? 'is-me' : ''}" id="message-${ message.id }">
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