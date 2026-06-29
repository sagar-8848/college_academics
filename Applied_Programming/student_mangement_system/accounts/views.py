from django.contrib import messages
from django.contrib.auth import login, logout
from django.shortcuts import render, redirect

from .forms import LoginForm


def login_view(request):

    if request.user.is_authenticated:
        return redirect("/")

    if request.method == "POST":

        form = LoginForm(request, data=request.POST)

        if form.is_valid():

            user = form.get_user()

            login(request, user)

            messages.success(
                request,
                f"Welcome back, {user.username}! 👋"
            )

            return redirect("/")

        else:

            messages.error(
                request,
                "Invalid username or password."
            )

    else:

        form = LoginForm()

    return render(
        request,
        "accounts/login.html",
        {"form": form},
    )


def logout_view(request):

    logout(request)

    messages.success(
        request,
        "Logged out successfully."
    )

    return redirect("login")