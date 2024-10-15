@component('mail::message')
# Olá, {{ $cliente->nome }}!

Agradecemos pelo seu pedido.

**Detalhes do Pedido:**
- Número do pedido: {{ $pedido->id }}
- Total: R$ {{ $pedido->total }}

@foreach ($pedido->produtos as $produto)
- {{ $produto['details']['nome'] }}: {{ $produto['quantidade'] }} x R$ {{ $produto['details']['preco'] }}
@endforeach

Aguardamos sua próxima compra!

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
