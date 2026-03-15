<select name="attendanceData" id="attendanceData" class="text-black" onchange="if(this.value) window.location.href = this.value">
    <option disabled selected value="">Select Type</option>
    <option value="{{ route('EmployeeAttendanceData') }}">Attendance</option>
    <option value="{{ route('EmployeeLateData') }}">Late</option>
    <option value="{{ route('EmployeeEarlyData') }}">Early Leave</option>
    <option value="{{ route('EmployeeAbsentData') }}">Absent</option>
    <option value="{{ route('EmployeeOvertimeData') }}">Overtime</option>
    <option value="{{ route('EmployeeHolidayData') }}">Holiday</option>
    <option value="{{ route('EmployeeWorkingDaysData') }}">Working Days</option>
    <option value="{{ route('EmployeeRemainingWorkingDaysData') }}">Remaining Working Days</option>
</select>
