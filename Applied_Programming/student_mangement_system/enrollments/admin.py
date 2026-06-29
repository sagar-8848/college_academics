from django.contrib import admin
from .models import Enrollment



@admin.register(Enrollment)
class EnrollmentAdmin(admin.ModelAdmin):
	list_display = ("enrollment_id", "student", "subject", "enrollment_date")
	search_fields = ("student__full_name", "student__roll_number", "subject__subject_name")