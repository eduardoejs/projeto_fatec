{{$token}}
{{$email}}
Nova senha:
CPF: {{ $user->cpf }}
@php    
    $str = '';
    $posicao = [0,4,8,12];    
    $index = rand(0,3);    
    if($posicao[$index] != 12){
        if($index == 0)
            $str = 'Os 3 primeiros dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
        if($index == 1)
            $str = 'O 4º,5º e 6º dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
        if($index == 2)
            $str = 'O 7º,8º e 9º dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 3);
    }else{
        $str = 'Os últimos dígitos do CPF: ' . substr($user->cpf, $posicao[$index], 2);
    }
    echo $str;
@endphp

ao validar remover token
