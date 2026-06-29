from django.db import models
from courses.models import Course
from faculties.models import Faculty


class Subject(models.Model):
    subject_id = models.AutoField(primary_key=True)
    subject_code = models.CharField(max_length=20, unique=True, blank=True, null=True)
    subject_name = models.CharField(max_length=100)
    credit_hours = models.IntegerField()

    faculty = models.ForeignKey(
        Faculty,
        on_delete=models.SET_NULL,
        blank=True,
        null=True,
        related_name="subjects",
        db_column="faculty_id",
    )

    course = models.ForeignKey(
        Course,
        on_delete=models.CASCADE,
        db_column="course_id",
    )

    class Meta:
        db_table = "subjects"

    def __str__(self):
        if self.subject_code:
            return f"{self.subject_name} ({self.subject_code})"
        return self.subject_name