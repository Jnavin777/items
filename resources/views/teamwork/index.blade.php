<x-minton-layout>
    <x-slot name="header">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Главная</a></li>
                    <li class="breadcrumb-item active">Команды</li>
                </ol>
            </div>
            <h4 class="page-title">Команды</h4>
        </div>
    </x-slot>
    <x-slot name="slot">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="header-title">Приглашения</h4>
                    <invites-table></invites-table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    @hasanyrole('Super Admin|Client')
                    <div class="panel-heading clearfix">
                        <a class="pull-right btn btn-default btn-sm" href="{{route('teams.create')}}">
                            <i class="fa fa-plus"></i> Создать новую команду
                        </a>
                    </div>
                    @endhasanyrole
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>{{$team->name}}</td>
                                        <td>
                                            @if(auth()->user()->isOwnerOfTeam($team))
                                                <span class="label label-success">Основатель</span>
                                            @else
                                                <span class="label label-primary">Участник</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(is_null(auth()->user()->currentTeam) || auth()->user()->currentTeam->getKey() !== $team->getKey())
                                                <a href="{{route('teams.switch', $team)}}" class="btn btn-sm btn-default">
                                                    <i class="fa fa-sign-in"></i> Переключить
                                                </a>
                                            @else
                                                <span class="label label-default">Текущая команда</span>
                                            @endif

                                            <a href="{{route('teams.members.show', $team)}}" class="btn btn-sm btn-default">
                                                <i class="fa fa-users"></i> Участники
                                            </a>


                                            @if(auth()->user()->isOwnerOfTeam($team))

                                                <a href="{{route('teams.edit', $team)}}" class="btn btn-sm btn-default">
                                                    <i class="fa fa-pencil"></i> Редактировать
                                                </a>

                                                <form style="display: inline-block;" action="{{route('teams.destroy', $team)}}" method="post">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Удалить</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

</x-minton-layout>
