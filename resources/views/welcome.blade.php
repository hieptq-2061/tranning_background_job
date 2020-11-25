<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job status</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    <div id="app" v-if="data" v-cloak>
        <div v-if="!data.monthlyEmail">
            Không có job nào
        </div>
        <div v-else>
            <h1>Tổng số mail cần gửi: @{{ data.monthlyEmail.totalJobs }}</h1>
            <h3>Trạng thái: @{{ data.monthlyEmail.endedAt ? 'Đã hoàn thành' : 'Chưa hoàn thành' }}</h3>
            <h3 v-if="data.monthlyEmail.endedAt">Hoàn thành lúc: @{{ data.monthlyEmail.endedAt }}</h3>
            <h3 v-else>Tổng số jobs đã chạy: @{{ data.monthlyEmail.jobsDone }}</h3>
            <h3>Tổng thời gian đã chạy: @{{ data.monthlyEmail.totalRunTime }}</h3>
            <h3>Tổng số jobs thành công: @{{ data.totalJobSuccess }}</h3>
            <h3>Tổng số jobs thất bại: @{{ data.totalJobFail }}</h3>
            <div v-if="data.failEmails">
                <table>
                    <caption><h3>Danh sách các email không gửi được</h3></caption>
                    <tr>
                        <th>STT</th>
                        <th>Email</th>
                    </tr>
                    <tr v-for="(email, index) in data.failEmails">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/home.js') }}" type="text/javascript"></script>
</body>
</html>
