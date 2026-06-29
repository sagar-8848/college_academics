from django.core.management.base import BaseCommand
from django.contrib.auth.models import Group, Permission
from django.contrib.contenttypes.models import ContentType

from students.models import Student
from courses.models import Course
from subjects.models import Subject
from faculties.models import Faculty
from enrollments.models import Enrollment
from exams.models import Exam
from results.models import Result


class Command(BaseCommand):
    help = "Create roles and assign permissions"

    def handle(self, *args, **kwargs):

        admin_group, _ = Group.objects.get_or_create(name="Admin")
        faculty_group, _ = Group.objects.get_or_create(name="Faculty")
        student_group, _ = Group.objects.get_or_create(name="Student")

        # Clear existing permissions
        admin_group.permissions.clear()
        faculty_group.permissions.clear()
        student_group.permissions.clear()

        # -----------------------------
        # Admin gets ALL permissions
        # -----------------------------
        admin_group.permissions.set(Permission.objects.all())

        # -----------------------------
        # Faculty Permissions
        # -----------------------------
        faculty_models = [
            Student,
            Exam,
            Result,
        ]

        for model in faculty_models:

            content_type = ContentType.objects.get_for_model(model)

            permissions = Permission.objects.filter(
                content_type=content_type
            )

            faculty_group.permissions.add(*permissions)

        # -----------------------------
        # Student Permissions
        # -----------------------------
        student_models = [
            Result,
            Enrollment,
        ]

        for model in student_models:

            content_type = ContentType.objects.get_for_model(model)

            permissions = Permission.objects.filter(
                content_type=content_type,
                codename__startswith="view"
            )

            student_group.permissions.add(*permissions)

        self.stdout.write(
            self.style.SUCCESS(
                "✅ Roles and permissions created successfully!"
            )
        )