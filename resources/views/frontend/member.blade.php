@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="topBlock">
            @if ($isNotCompleteSurveyId)
                <div class="fixCen hasBefore" id="filterMember">
                    <h2 class="title">Chưa hoàn thành khảo sát</h2>
                    @if (\App\Helpers::currentFrontendUserIsAdmin())
                    @if (!\App\Helpers::isDemoCustomer())
                        <button type="button" id="remindButton" class="myBtn btnSave">Nhắc nhở</button>
                        <form id="remindForm" action="{{ route('frontend.post_member_remind') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="survey_id"  value="{{ $isNotCompleteSurveyId }}">
                        </form>
                    @endif
                    @endif
                </div>

            @else
                <div class="fixCen hasBefore" id="filterMember">
                    <h2 class="title">Danh sách thành viên</h2>
                    @if (\App\Helpers::currentFrontendUserIsAdmin())
                    <a href="{{ route('frontend.member_create') }}" class="myBtn addNewUser" title="Thêm mới">+ Thêm mới</a>

                    @endif


                    <form action="{{ route('frontend.member') }}" method="GET" class="searchUser">
                        <input type="text" placeholder="Tên/email" onfocus="this.value=''" value="{{ request()->input('q') }}" id="inputSearchDemo" name="q" autocomplete="off">

                        <div id="autocomplete-list" class="autocomplete-items" style="display: none"></div>
                    </form>


                </div>
            @endif
        </div>
        <div class="editSurveyBlock editBlock">
            <div class="fixCen">
                <div class="box">
                    <table class="tableList tableListMember">
                        <thead>
                        <tr>
                            <td>STT</td>
                            <td>Tên </td>
                            <td>Email</td>
                            @if ($company->filters)
                                @foreach ($company->filters as $filter)
                                <td>
                                    {{ $filter->name }}
                                </td>
                                @endforeach
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $index => $customer)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>
                                <a href="{{ route('frontend.personal').'?id='.$customer->id }}" class="link" title="Tên thành viên">{{ $customer->name }}</a>

                                @if (\App\Helpers::currentFrontendUserIsAdmin())

                                <a href="{{ route('frontend.member_detail').'?id='.$customer->id }}" class="btnEditMember" title="Sửa thông tin"></a>
                                @endif
                            </td>
                            <td>{{ $customer->email }}</td>

                            @if ($company->filters)
                                @foreach ($company->filters as $filter)
                                    <td>
                                        {{ \App\Helpers::getCustomerFilterValue($customer, $filter) }}
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                @include('frontend.pagination', ['paginate' => $customers])
            </div>
        </div>
    </main>

@endsection

@section('after_styles')
    <style>
        .autocomplete {
            /*the container must be positioned relative:*/
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;

        }
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }
        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }
        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
@endsection

@section('after_scripts')

    <script>

        function autocomplete(inp) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible auto completed values:*/
            let currentFocus;

            let arr = [];

            let a = document.getElementById('autocomplete-list');


            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                let b, i, val = this.value;
                /*close any already open lists of auto completed values*/
                closeAllLists();
                if (!val) { return false;}

                $.get("{{ route('frontend.ajax') }}", { q : val }, function(res){
                    if (res.customers) {
                        arr = res.customers;
                        a.style.display = 'block';
                        a.innerHTML = "";
                        currentFocus = -1;
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {
                            /*check if the item starts with the same letters as the text field value:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);
                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function(e) {
                                /*insert the value for the autocomplete text field:*/
                                inp.value = this.getElementsByTagName("input")[0].value;
                                /*close the list of auto completed values,
                                (or any other open lists of auto completed values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);

                        }
                    }
                });


            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {

                let x = a.getElementsByTagName("div");

                if (e.keyCode === 40 && a.style.display === 'block') {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode === 38 && a.style.display === 'block') { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode === 13 && a.style.display === 'block') {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                let x = document.getElementById("autocomplete-list");
                for (let i = 0; i < x.length; i++) {
                    if (elmnt !== x[i] && elmnt !== inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
                x.style.display = 'none';
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }


        $(function(){
            $('#remindButton').click(function(){
                $('#remindForm').submit();
                return false;
            });
            autocomplete(document.getElementById("inputSearchDemo"));


        });
    </script>

@endsection