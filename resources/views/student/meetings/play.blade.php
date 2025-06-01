<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h2 class="text-xl font-bold mb-6">Quiz: {{ $meeting->quiz->title }}</h2>

        <div id="questions">
            @foreach($meeting->quiz->questions as $question)
                <div class="mb-4">
                    <p class="font-semibold">{{ $question->text }}</p>
                    @foreach($question->options as $option)
                        <label class="block">
                            <input type="radio"
                                   name="question_{{ $question->id }}"
                                   value="{{ $option->id }}"
                                   onchange="submitAnswer({{ $question->id }}, {{ $option->id }})">
                            {{ $option->text }}
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function submitAnswer(questionId, optionId) {
            fetch(`/answer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    question_id: questionId,
                    option_id: optionId,
                    meeting_id: {{ $meeting->id }},
                })
            }).then(res => {
                if (!res.ok) {
                    console.error('Fallo al guardar respuesta');
                }
            });
        }
    </script>
</x-app-layout>
