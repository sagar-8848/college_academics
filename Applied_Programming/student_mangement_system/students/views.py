from django.contrib import messages
from django.core.paginator import Paginator
from django.db.models import Q
from django.shortcuts import get_object_or_404, redirect, render

from courses.models import Course
from enrollments.models import Enrollment
from exams.models import Exam
from faculties.models import Faculty
from results.models import Result
from subjects.models import Subject

from .forms import StudentForm
from .models import Student
from django.contrib.auth.decorators import login_required
from accounts.decorators import permission_required

from django.contrib.auth.models import Group, User
from django.db import transaction
# from accounts.decorators import permission_required

# from django.db.models import Count

@login_required
def dashboard(request):

    # ==========================
    # Student Dashboard
    # ==========================
    if request.user.groups.filter(name="Student").exists():

        student = Student.objects.filter(user=request.user).first()

        if not student:
            messages.error(
                request,
                "No student profile is linked to this account."
            )
            return redirect("logout")

        context = {

            "student": student,

            "total_enrollments": Enrollment.objects.filter(
                student=student
            ).count(),

            "total_results": Result.objects.filter(
                student=student
            ).count(),

            "total_exams": Exam.objects.filter(
                subject__enrollment__student=student
            ).distinct().count(),

        }

        return render(
            request,
            "dashboard/student_dashboard.html",
            context,
        )

    # ==========================
    # Admin / Faculty Dashboard
    # ==========================

    context = {

        "total_students": Student.objects.count(),

        "total_courses": Course.objects.count(),

        "total_subjects": Subject.objects.count(),

        "total_faculties": Faculty.objects.count(),

        "total_enrollments": Enrollment.objects.count(),

        "total_exams": Exam.objects.count(),

        "total_results": Result.objects.count(),

    }

    return render(
        request,
        "dashboard/admin_dashboard.html",
        context,
    )

# ? student lists
@login_required
@permission_required("students.view_student")
def student_list(request):

    search_query = request.GET.get("search", "")

    students = Student.objects.all()

    if search_query:
        students = students.filter(
            Q(full_name__icontains=search_query)
            | Q(roll_number__icontains=search_query)
            | Q(email__icontains=search_query)
        )
    paginator = Paginator(students, 10)
    page_number = request.GET.get("page")

    page_obj = paginator.get_page(page_number)

    context = {

        "students": page_obj,

        "page_obj": page_obj,

        "search_query": search_query,

    }

    return render(
        request,
        "students/student_list.html",
        context
    )

# * add student
@login_required
@permission_required("students.add_student")
def add_student(request):
    form = StudentForm(request.POST or None)

    if request.method == "POST" and form.is_valid():

        with transaction.atomic():

            # Create Django User
            user = User.objects.create_user(
                username=form.cleaned_data["username"],
                email=form.cleaned_data["email"],
                password=form.cleaned_data["password"],
            )

            # Add User to Student Group
            student_group, created = Group.objects.get_or_create(name="Student")
            user.groups.add(student_group)

            # Create Student
            student = form.save(commit=False)
            student.user = user
            student.save()

        messages.success(
            request,
            f"Student '{student.full_name}' created successfully!"
        )

        return redirect("student_list")

    return render(
        request,
        "shared/form.html",
        {
            "form": form,
            "form_title": "Add Student",
            "submit_label": "Save Student",
            "cancel_url": "/students/",
        },
    )

    form = StudentForm(request.POST or None)

    if request.method == "POST" and form.is_valid():
        form.save()

        messages.success(request, "Student added successfully!")

        return redirect("student_list")

    return render(
        request,
        "shared/form.html",
        {
            "form": form,
            "form_title": "Add Student",
            "submit_label": "Save Student",
            "cancel_url": "/students/",
        },
    )

# * edit student
@login_required
@permission_required("students.change_student")
def edit_student(request, student_id):

    student = get_object_or_404(
        Student,
        student_id=student_id
    )

    form = StudentForm(request.POST or None, instance=student)

    if request.method == "POST" and form.is_valid():
        form.save()

        messages.success(request, "Student updated successfully!")

        return redirect("student_list")

    return render(
        request,
        "shared/form.html",
        {
            "form": form,
            "form_title": "Edit Student",
            "submit_label": "Update Student",
            "cancel_url": "/students/",
        }
    )


# * delete student
@login_required
@permission_required("students.delete_student")
def delete_student(request, student_id):

    student = get_object_or_404(
        Student,
        student_id=student_id
    )

    if request.method == "POST":

        student.delete()

        messages.success(
            request,
            "Student deleted successfully!"
        )

        return redirect("student_list")

    return render(
        request,
        "shared/confirm_delete.html",
        {
            "title": "Delete Student",
            "message": f"Are you sure you want to delete {student.full_name}?",
            "confirm_label": "Delete Student",
            "cancel_url": "/students/",
        }
    )