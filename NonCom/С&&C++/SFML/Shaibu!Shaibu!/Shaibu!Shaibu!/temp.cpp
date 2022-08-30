#include <SFML/Graphics.hpp>
#include <Windows.h>
#include <cmath>
#include <iostream>
#define g 9.8;
#define iter 10000;
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


void DrawTunnel(RenderWindow& window, double H, double L)
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

void Recount(double& Vo, double& Vx, double& Vy, double& VoX, double& VoY, double& VxPrev, double& VyPrev, double Beta)
{
	Vo = sqrt(Vx * Vx + Vy * Vy);
	VoX = Vo * cos(Beta), VoY = Vo * sin(Beta);
	VxPrev = VoX, VyPrev = VoY;
}

void Show(RenderWindow& window, float& timer, Text& Speed, float time, double Vx, double Vy, Text& SpeedX, Text& SpeedY)
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


int didItHit(RenderWindow& window, double H, double L, double Alpha, double r, CircleShape shape)
{
	Vector2u WindowSize = window.getSize();
	double   x1, x2, y1, y2, k, b;
	Vector2f Position = shape.getPosition();

	//верхн€€ стенка
	x1 = WindowSize.x / 2 - L / 2;
	y1 = WindowSize.y - H - 100;

	x2 = round(H * cos(Alpha) + x1);
	y2 = round(H * sin(Alpha) + y1);

	k = (y2 - y1) / (x2 - x1);
	b = (x2 * y1 - x1 * y2) / (x2 - x1);

	if (Position.y <= k * Position.x + b)
		return 1;

	//нижн€€ стенка
	x1 = WindowSize.x / 2 + L / 2;
	y1 = WindowSize.y - H - 100;

	x2 = H * cos(Alpha) + x1;
	y2 = H * sin(Alpha) + y1;

	k = (y2 - y1) / (x2 - x1);
	b = (x2 * y1 - x1 * y2) / (x2 - x1);

	if (Position.y + r * 2 >= k * Position.x + r * 2 + b)
		return 2;

	return 0;
}


int main()
{
	setlocale(LC_ALL, "rus");
	float r = 25;
	double mu = 0.05, m, Xo, Yo, Vo, Alpha, Beta, H, L;
	/*cout << "¬ведите m и r";
	cin >> m >> r;*/
	cout << "¬ведите Xo,Yo и Vo: ";
	cin >> Xo >> Yo >> Vo;
	cout << "¬ведите угол Alpha и Beta: ";
	cin >> Alpha >> Beta;
	cout << "¬ведите H и L: ";
	cin >> H >> L;

	Alpha = (360 - Alpha) * Pi / 180;
	Beta = (360 - Beta) * Pi / 180;

	double a = -mu * g;
	double VoX = Vo * cos(Beta), VoY = Vo * sin(Beta);

	double x, y, x2, y2, Vx, Vy, VxPrev = VoX, VyPrev = VoY;

	sf::RenderWindow window(sf::VideoMode(GetSystemMetrics(SM_CXSCREEN), GetSystemMetrics(SM_CYSCREEN)), "Shaibu! Shaibu!");
	sf::CircleShape shape;

	Vector2u WindowSize = window.getSize();



	shape.setRadius(r);
	shape.setFillColor(sf::Color::Green);
	shape.setPosition(GetSystemMetrics(SM_CXSCREEN) / 2 - r, GetSystemMetrics(SM_CYSCREEN) - 100 - r * 2);
	Vector2f Position = shape.getPosition();
	x2 = Position.x;
	y2 = Position.y;

	Clock clock;
	while (window.isOpen())
	{
		sf::Event event;
		float time = clock.getElapsedTime().asMicroseconds();
		clock.restart();
		time = time / 1000;
		float timer = 0;

		Font font;
		font.loadFromFile("Text.ttf");


		Text Speed("", font, 75);
		Speed.setPosition(200, 310);

		Text SpeedX("", font, 75);
		SpeedX.setPosition(200, 150);

		Text SpeedY("", font, 75);
		SpeedY.setPosition(200, 230);

		while (window.pollEvent(event))
		{
			if (event.type == sf::Event::Closed)
				window.close();
			if (event.type == Event::MouseButtonPressed && event.key.code == Mouse::Left)//изменить кол-во игроков
			{
				do
				{
					sf::sleep(sf::milliseconds(10)); //задержка


					Vx = VxPrev - a / iter;
					if (x2 + Vx * time + r * 2 >= WindowSize.x / 2 + L / 2) //права€ стена
					{
						//угол отражени€
						Beta = Beta * 180 / Pi;
						Beta = Beta - 180 + 2 * (360 - Beta);
						Beta = Beta * Pi / 180;

						Vx = VxPrev + a / iter;
						Recount(Vo, Vx, Vy, VoX, VoY, VxPrev, VyPrev, Beta);
						Vx = VxPrev - a / iter;
					}
					else if (x2 + Vx * time <= WindowSize.x / 2 - L / 2)//лева€ стена
					{
						//угол отражени€
						Beta = Beta * 180 / Pi;
						Beta = Beta - 180 + 2 * (360 - Beta);
						Beta = Beta * Pi / 180;

						Vx = VxPrev + a / iter;
						Recount(Vo, Vx, Vy, VoX, VoY, VxPrev, VyPrev, Beta);
						Vx = VxPrev - a / iter;
					}
					else if (int k = didItHit(window, H, L, Alpha, r, shape) > 0)
					{
						if (k == 1)//лева€ стена
						{
							//угол отражени€
							Beta = 3.14 - (6.28 - Beta) - (6.28 - Alpha);

							Vx = VxPrev + a / iter;
							Recount(Vo, Vx, Vy, VoX, VoY, VxPrev, VyPrev, Beta);
							Vx = VxPrev - a / iter;

						}
						else if (k == 2)
						{
							//угол отражени€
							Beta = (6.28 - Beta) - 1.57 + (6.28 - Alpha);

							Vx = VxPrev + a / iter;
							Recount(Vo, Vx, Vy, VoX, VoY, VxPrev, VyPrev, Beta);
							Vx = VxPrev - a / iter;
						}
					}

					VxPrev = Vx;
					x = x2 + Vx * time;
					x2 = x;


					Vy = VyPrev - a / iter;
					VyPrev = Vy;
					y = y2 + Vy * time;
					y2 = y;

					shape.setPosition(x, y);


					window.clear(Color::White);
					DrawTunnel(window, H, L);
					Show(window, timer, Speed, time, Vx, Vy, SpeedX, SpeedY);
					window.draw(shape);
					window.display();
				} while (round(sqrt(Vx * Vx + Vy * Vy)) > 0 && y + r * 2 > 0);



			}
		}

		window.clear(Color::White);
		DrawTunnel(window, H, L);
		window.draw(shape);
		window.display();
	}

	return 0;
}