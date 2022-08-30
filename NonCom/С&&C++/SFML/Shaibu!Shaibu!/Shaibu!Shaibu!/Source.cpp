#include <SFML/Graphics.hpp>
#include <Windows.h>
#include <cmath>
#include <iostream>
#include <time.h>

#define g 9.8;
#define iter 100;
#define Pi 3.141592653589793
using namespace std;
using namespace sf;

class linePoint
{
public:
	Vector2f start;
	Vector2f end;
	int H;
};


void DrawTunnel(RenderWindow& window,double H,double L)
{
	Vector2u WindowSize = window.getSize();

	RectangleShape lineLeft(Vector2f(H, 2));
	lineLeft.rotate(90.f);
	lineLeft.setFillColor(Color::Green);
	lineLeft.move(WindowSize.x / 2 - L / 2, WindowSize.y - H - 100);


	RectangleShape lineRight(Vector2f(H, 2));
	lineRight.rotate(90.f);
	lineRight.setFillColor(Color::Green);
	lineRight.move(WindowSize.x / 2 + L / 2, WindowSize.y - H - 100);


	RectangleShape lineRightSlop(Vector2f(H, 2));
	lineRightSlop.rotate(-45.f);
	lineRightSlop.setFillColor(Color::Green);
	lineRightSlop.move(WindowSize.x / 2 + L / 2, WindowSize.y - H - 100);


	RectangleShape lineLeftSlop(Vector2f(H, 2));
	lineLeftSlop.rotate(-45);
	lineLeftSlop.setFillColor(Color::Green);
	lineLeftSlop.move(WindowSize.x / 2 - L / 2, WindowSize.y - H - 100);

	window.draw(lineLeft);
	window.draw(lineLeftSlop);
	window.draw(lineRightSlop);
	window.draw(lineRight);
}

void Recount(double &V, double& Vx, double& Vy,double Beta)
{
	Vx = V * cos(Beta);
	Vy = V * sin(Beta);
	
}

void Show(RenderWindow& window,float &timer, Text & Speed,float time, double Vx, double Vy, Text& SpeedX, Text& SpeedY)
{
	string nums;
	timer += time;

	nums = to_string(sqrt(Vx * Vx + Vy * Vy));
	Speed.setFillColor(Color::Green);
	Speed.setString(nums);

	nums = to_string(Vx);
	SpeedX.setFillColor(Color::Green);
	SpeedX.setString(nums);

	nums = to_string(Vy);
	SpeedY.setFillColor(Color::Green);
	SpeedY.setString(nums);

	window.draw(Speed);
	window.draw(SpeedX);
	window.draw(SpeedY);
}

void Show(RenderWindow& window, double x,double y, Text& X, Text& Y,double S, Text& Stext)
{
	string nums;
	

	nums = to_string(x);
	X.setFillColor(Color::Green);
	X.setString(nums);

	nums = to_string(y);
	Y.setFillColor(Color::Green);
	Y.setString(nums);

	nums = to_string(S);
	Stext.setFillColor(Color::Green);
	Stext.setString(nums);

	window.draw(X);
	window.draw(Y);
	window.draw(Stext);
	
}

int didItHit(RenderWindow& window, double H, double L,double Alpha, double Beta,double r, CircleShape shape,double Vx ,double Vy,double Xprev,float time )
{
	Vector2u WindowSize = window.getSize();
	double k,b, x1, x2, y1, y2;
	Vector2f Position = shape.getPosition();
	Vector2f Center;
	Center.x = Position.x + r ;
	Center.y = Position.y + r;
	if (Position.y > WindowSize.y - H - 100)
	{
		//права€ пр€ма€ стена 
		if (Xprev + Vx * time + r * 2 >= WindowSize.x / 2 + L / 2)
			return 1;

		//лева€  пр€ма€ стена 
		if (Xprev + Vx * time <= WindowSize.x / 2 - L / 2)
			return 2;

		//пол
		if (Position.y + r * 2 >= WindowSize.y - 99)
			return 6;
	}
	else
	{
		//верхн€€ стенка
		x1 = WindowSize.x / 2 - L / 2;
		y1 = WindowSize.y - H - 100;

		x2 = H * cos(Alpha) + x1;
		y2 = H * sin(Alpha) + y1;

		k = (y2 - y1) / (x2 - x1);
		b = y2 - k * x2;
		//double Beta2 =6.28- (180*Pi/180)-((90 * Pi / 180) - (6.28-Alpha));
		if (Center.y +Vy + r * sin(Beta) <= k * (Center.x+Vx  + r * cos(Beta)) + b)
		{
			sf::Vertex point(sf::Vector2f(Center.x  + r * cos(1.57-Beta), Center.y  + r * sin(1.57-Beta)), sf::Color::Red);
			window.draw(&point, 1, sf::Points);
			window.display();
			return 3;
		}
			

		//нижн€€ стенка
		x1 = WindowSize.x / 2 + L / 2;
		y1 = WindowSize.y - H - 100;

		x2 = H * cos(Alpha) + x1;
		y2 = H * sin(Alpha) + y1;

		k = (y2 - y1) / (x2 - x1);
		b = y2 - k * x2;

		if (Center.y+Vy + r * sin(Beta) >= k * (Center.x+Vx + r * cos(Beta)) + b)
			
			return 4;

		//потолок
		if (Position.y+Vy <= H * sin(Alpha) + WindowSize.y - H- 100 )
			return 5;
	}

	return 0;
}


int main()
{
	//S=Vo^2 /2*mu*g
	setlocale(LC_ALL, "rus");
	float r=25;
	double mu = 0.05,m,Xo,Yo,Vo,Alpha,Beta,H,L,S=0,V;
	/*cout << "¬ведите  r: ";
	cin >> r;*/
	cout << "¬ведите Xo,Yo и Vo: ";
	cin >> Xo >> Yo >> V;
	cout << "¬ведите угол Alpha и Beta: ";
	cin >> Alpha >> Beta;
	cout << "¬ведите H и L: ";
	cin >> H >> L;

	Alpha =(360-Alpha )* Pi / 180;
	Beta = (360-Beta )* Pi / 180;

	double a = mu * g;
	double VoX= V * cos(Beta),VoY = V * sin(Beta), Vprev=V;

	double x, y, x2, y2, Vx,Vy,VxPrev, VyPrev ;

	sf::RenderWindow window(sf::VideoMode(GetSystemMetrics(SM_CXSCREEN), GetSystemMetrics(SM_CYSCREEN)), "Shaibu! Shaibu!");
	sf::CircleShape shape;

	Vector2u WindowSize = window.getSize();

	

	shape.setRadius(r);
	shape.setFillColor(sf::Color::Green);
	shape.setPosition(GetSystemMetrics(SM_CXSCREEN)/2-r, GetSystemMetrics(SM_CYSCREEN)-100-r*2);
	//shape.setPosition(Xo, Yo);
	Vector2f Position = shape.getPosition();
	x2 = Position.x;
	y2 = Position.y;

	Clock clock;
	while (window.isOpen())
	{
		sf::Event event;
		float time= clock.getElapsedTime().asSeconds();
		clock.restart();
		time = time / 1000;
		float timer=0;

		Font font;
		font.loadFromFile("Text.ttf");
		
		
		Text Speed("", font, 75);
		Speed.setPosition(0, 310);
		
		Text SpeedX("", font, 75);
		SpeedX.setPosition(200, 150);

		Text SpeedY("", font, 75);
		SpeedY.setPosition(200, 230);

		Text X("", font, 75);
		X.setPosition(200, 150);

		Text Y("", font, 75);
		Y.setPosition(200, 230);

		Text Stext("", font, 75);
		Stext.setPosition(200, 310);

		while (window.pollEvent(event))
		{
			if (event.type == sf::Event::Closed)
				window.close();
			if (event.type == Event::MouseButtonPressed && event.key.code == Mouse::Left)//изменить кол-во игроков
			{
				do
				{
					sf::sleep(sf::milliseconds(10)); //задержка
					 Position = shape.getPosition();
					 V = Vprev - a / iter;
					//Vx = VxPrev - a / CLOCKS_PER_SEC;
					 Vx = V * cos(Beta);
					 Vy = V * sin(Beta);

					 switch (didItHit(window, H, L, Alpha,Beta, r, shape,Vx,Vy,x2,time))
					 {
					 case 0:
						 break;
						 
					 case 1: //права€ пр€ма€ стена 
						 /*Beta = Beta * 180 / Pi;
						 Beta = Beta - 180 + 2 * (360 - Beta);
						 Beta = Beta * Pi / 180;*/
						 Beta = (2 * 1.57) - Beta;
					 	
						 V = Vprev + a / iter;
						 Recount(V, Vx, Vy, Beta);
						 V = Vprev - a / iter;
						 break;
						 
					 case 2:  //лева€  пр€ма€ стена
						 /*Beta = Beta * 180 / Pi;
						 Beta = Beta - 180 + 2 * (360 - Beta);
						 Beta = Beta * Pi / 180;*/
						 Beta = (2 * 1.57) - Beta;

						 V = Vprev + a / iter;
						 Recount(V, Vx, Vy, Beta);
						 V = Vprev - a / iter;
					 break;
					
					 case 3:  //верхн€€ стенка
						 Beta = (2 * Alpha) - Beta;
					

						 V = Vprev + a / iter;
						 Recount(V, Vx, Vy, Beta);
						 V = Vprev - a / iter; 
						 break;
						
					 case 4: //нижн€€ стенка
						 Beta = (2 * Alpha) - Beta;

						 V = Vprev + a / iter;
						 Recount(V, Vx, Vy, Beta);
						 V = Vprev - a / iter; 
						 break;
						
					 case 5:  //потолок
						 Beta = Beta * 180 / Pi;
						 Beta = Beta - 360 + 2 * (360 - Beta);
						 Beta = Beta * Pi / 180;

						 V = Vprev + a / iter;
						 Recount(V, Vx, Vy, Beta);
						 V = Vprev - a / iter; 
						 break;
						 
					 case 6: //пол
						
						 Beta = (2 * 3.14) - Beta;
						 

						 V = Vprev + a / iter;
						 Recount(V, Vx, Vy, Beta);
						 V = Vprev - a / iter; 
					     break;
					 }
			
					Vprev = V;
					x = x2 + Vx;
					x2 = x;


					
					y = y2 + Vy;
					y2 = y;

					S += sqrt(Vx * Vx + Vy * Vy)/100;
					shape.setPosition(x, y);
					Time tmp = milliseconds(200);
					//sleep(Time(tmp));

					window.clear(Color::White);
					DrawTunnel(window, H, L);
					//Show(window, timer, Speed, time,Vx,Vy, SpeedX, SpeedY);
					Show(window, Position.x,Position.y,X,Y,S,Stext);
					window.draw(shape);
					window.display();
				} while (V>0&&y-r*2>0&&y+r*2< GetSystemMetrics(SM_CYSCREEN));

		
				
			}
		}

		window.clear(Color::White);
		DrawTunnel(window, H, L);
		window.draw(shape);
		Show(window, Position.x, Position.y, X, Y, S, Stext);
		window.display();
	}

	return 0;
}