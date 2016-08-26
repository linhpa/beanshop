<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Modals\Login;
use AppBundle\Entity\User;

class UserController extends Controller
{
	public function loginAction(Request $request)
	{
		$session = $request->getSession();
		if ($request->isMethod('GET'))
		{
			return $this->render('default/login.html.twig', array());
		}
		elseif ($request->isMethod('POST'))
		{
			$session->clear();
			$username = $request->get('username');
			$password = $request->get('password');

			$user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByUsername($username);

			if (!$user) {
				echo "<script language='javascript'>alert('Username is invalid')</script>";
				return $this->render('default/login.html.twig', array());
			}

			elseif ($password != $user->getPassword())
			{
				echo "<script language='javascript'>alert('Wrong password')</script>";
				return $this->render('default/login.html.twig', array());
			}
			else {
				$level = $user->getLevel();
				$login = new Login();
				$login->setUsername($username);
				$login->setPassword($password);
				$login->setLevel($level);

				$session->set('login', $login);
				return $this->redirectToRoute('home_page', array(), 302);
			}
		}
	}

	//Logout

	public function logoutAction(Request $request)
	{
		$session = $request->getSession();
		$session->clear();
		return $this->redirectToRoute('home_page', array());
	}

	//register

	public function register(Request $request)
	{
		return $this->render('default/register.html.twig', []);
	}
	
	public function registerHandleAction(Request $request)
	{
		$username = $request->get('username');
		$password = $request->get('password');
		$email = $request->get('email');
		$phone = $request->get('phone');

		

		$errors = array();
		if (!preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,50}$/', $username))
		{
			$errors['username'] = "Error username";
		}

		if (!preg_match('/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[~!@#$%^&*]).{6,50}/', $password))
		{	
			$errors['password'] = "Error password";
		}

		 if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors['email'] = 'Wrong function of email';
        }
		
		if (!empty($this->getDoctrine()->getRepository('AppBundle:User')->findOneByUsername($username)))
		{
			echo "<script language='JavaScript'>alert('Username is invalid');</script>";
            return $this->render('default/register.html.twig', array());
		}

		elseif (!empty($errors))
        {
            echo "<script language='JavaScript'>alert('Wrong function. Input again');</script>";
            return $this->render('default/register.html.twig', $errors);
        }
        else
        {
			$user = new User();
			$user->setUsername($username);
			$user->setPassword($password);
			$user->setEmail($email);
			$user->setPhone($phone);
			$user->setLevel('2');

			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			$mess = "Register Successfully!";
			return $this->render('default/login.html.twig', ['mess' => $mess,]);
		}
	}
}

?>