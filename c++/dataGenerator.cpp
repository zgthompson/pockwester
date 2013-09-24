#include<iostream>
#include<fstream>
#include<vector>
#include<cstdlib>
#include<ctime>

using namespace std;

string availability();

int main()
{
    ifstream names("names.txt");
    vector <string> nameHolder;
    while(names.good())
    {
        string temp;
        names >> temp;
        nameHolder.push_back(temp);
        cout << temp << endl;
    }
    ofstream data("data.txt");
    for(unsigned int i = 0;i <= nameHolder.size()-2;i+=2)
    {
        data << "'" << nameHolder[i] << " " << nameHolder[i+1] << "',";
        data << "'" << availability() << "'" << endl;
    }
    data.close();
    names.close();
    return 0;
}

string availability()
{
    string avail;
    for(int i = 0;i <= 168;i++)
    {
        int temp = rand() % 2;
        if(temp == 0)
        {
            avail+= '0';
        }
        else
        {
            avail+= '1';
        }
    }
    return avail;

}
