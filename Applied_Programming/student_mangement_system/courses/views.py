from django.shortcuts import render, redirect, get_object_or_404
from django.contrib import messages
from django.core.paginator import Paginator

from .models import Course
from django.contrib.auth.decorators import login_required
from accounts.decorators import permission_required

@login_required
@permission_required("courses.view_course")
def course_list(request):

    search_query = request.GET.get("search", "")

    courses = Course.objects.all()

    if search_query:
        courses = courses.filter(course_name__icontains=search_query)

    paginator = Paginator(courses, 5)

    page_number = request.GET.get("page")

    page_obj = paginator.get_page(page_number)

    context = {
        "courses": page_obj,
        "page_obj": page_obj,
        "search_query": search_query,
    }

    return render(request, "courses/course_list.html", context)

@login_required
@permission_required("courses.add_course")
def add_course(request):

    if request.method == "POST":

        Course.objects.create(
            course_name=request.POST["course_name"],
            duration=request.POST["duration"],
        )

        messages.success(request, "Course added successfully!")

        return redirect("course_list")

    return render(request, "courses/add_course.html")

@login_required
@permission_required("courses.change_course")
def edit_course(request, course_id):

    course = get_object_or_404(
        Course,
        course_id=course_id
    )

    if request.method == "POST":

        course.course_name = request.POST["course_name"]
        course.duration = request.POST["duration"]

        course.save()

        messages.success(request, "Course updated successfully!")

        return redirect("course_list")

    return render(
        request,
        "courses/edit_course.html",
        {
            "course": course
        }
    )

@login_required
@permission_required("courses.delete_course")
def delete_course(request, course_id):

    course = get_object_or_404(
        Course,
        course_id=course_id
    )

    if request.method == "POST":

        course.delete()

        messages.success(request, "Course deleted successfully!")

        return redirect("course_list")

    return render(
        request,
        "courses/confirm_delete.html",
        {
            "course": course
        }
    )